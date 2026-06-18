<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Subsystem;

class EventBusService
{
    public function dispatch(string $event, array $payload = []): void
    {
        // Send webhooks to all active subsystems with webhook_url
        $subsystems = Subsystem::where('is_active', true)->get();
        $hasWebhooks = false;

        foreach ($subsystems as $subsystem) {
            $metadata = $subsystem->metadata ?? [];
            if (!empty($metadata['webhook_url'])) {
                $hasWebhooks = true;
                $this->sendWebhook($subsystem, $event, $payload);
            }
        }

        // Dispatch via RabbitMQ for async processing
        $this->dispatchRabbitMQ($event, $payload);
    }

    protected function sendWebhook(Subsystem $subsystem, string $event, array $payload): void
    {
        $metadata = $subsystem->metadata ?? [];
        $webhookUrl = $metadata['webhook_url'] ?? null;

        if (!$webhookUrl) {
            return;
        }

        try {
            Http::timeout(5)
                ->withHeaders([
                    'X-API-Key' => $subsystem->api_key,
                    'Content-Type' => 'application/json',
                ])
                ->post($webhookUrl, [
                    'event' => $event,
                    'payload' => $payload,
                    'timestamp' => now()->toIso8601String(),
                ]);
        } catch (\Throwable $e) {
            Log::warning("Webhook dispatch failed for {$subsystem->name}: {$e->getMessage()}");
        }
    }

    protected function dispatchRabbitMQ(string $event, array $payload): void
    {
        try {
            $rabbitmq = app(RabbitMQService::class);
            $rabbitmq->publish($event, $payload);
        } catch (\Throwable $e) {
            Log::warning("RabbitMQ dispatch failed: {$e->getMessage()}");
        }
    }
}

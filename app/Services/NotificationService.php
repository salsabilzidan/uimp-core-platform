<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    public function send(array $data): Notification
    {
        $notification = Notification::create([
            'type'      => $data['type'] ?? 'email',
            'channel'   => $data['channel'] ?? 'mail',
            'recipient' => $data['recipient'],
            'subject'   => $data['subject'] ?? null,
            'body'      => $data['body'],
            'status'    => 'pending',
            'metadata'  => $data['metadata'] ?? null,
        ]);

        try {
            match ($notification->type) {
                'email' => $this->sendEmail($notification),
                'in_app' => $this->sendInApp($notification),
                'sms' => $this->sendSms($notification),
                default => $this->sendEmail($notification),
            };

            $notification->update(['status' => 'sent', 'sent_at' => now()]);
        } catch (\Exception $e) {
            $notification->update(['status' => 'failed']);
            Log::error("Notification failed: {$e->getMessage()}");
        }

        return $notification;
    }

    protected function sendEmail(Notification $notification): void
    {
        Mail::raw($notification->body, function ($message) use ($notification) {
            $message->to($notification->recipient)
                    ->subject($notification->subject ?? 'UIMP Notification');
        });
    }

    protected function sendInApp(Notification $notification): void
    {
        // In-app notifications are stored in DB and fetched via API
    }

    protected function sendSms(Notification $notification): void
    {
        // SMS integration placeholder
        // Integrate with SMS provider (e.g., Twilio, Unifonic, SMSA)
        Log::info("SMS sent to {$notification->recipient}: {$notification->body}");
    }
}

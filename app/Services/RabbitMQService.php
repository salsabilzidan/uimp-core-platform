<?php

namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Illuminate\Support\Facades\Log;

class RabbitMQService
{
    protected ?AMQPStreamConnection $connection = null;
    protected string $exchange;
    protected static bool $available = true;

    public function __construct()
    {
        // Fix for Windows: Socket constants not defined in PHP on Windows
        if (!defined('SOCKET_EAGAIN')) {
            define('SOCKET_EAGAIN', 11);
        }
        if (!defined('SOCKET_EWOULDBLOCK')) {
            define('SOCKET_EWOULDBLOCK', 11);
        }
        if (!defined('SOCKET_ECONNRESET')) {
            define('SOCKET_ECONNRESET', 104);
        }
        if (!defined('SOCKET_ETIMEDOUT')) {
            define('SOCKET_ETIMEDOUT', 110);
        }

        $this->exchange = env('RABBITMQ_EXCHANGE', 'uimp_events');
    }

    protected function connect(): void
    {
        if ($this->connection) {
            return;
        }

        if (!self::$available) {
            return;
        }

        try {
            $this->connection = new AMQPStreamConnection(
                host: env('RABBITMQ_HOST', '127.0.0.1'),
                port: env('RABBITMQ_PORT', 5672),
                user: env('RABBITMQ_USER', 'guest'),
                password: env('RABBITMQ_PASSWORD', 'guest'),
                vhost: env('RABBITMQ_VHOST', '/'),
                connection_timeout: 0.3,
                read_write_timeout: 1,
            );
            self::$available = true;
        } catch (\Throwable $e) {
            self::$available = false;
            Log::warning("RabbitMQ connection failed: {$e->getMessage()}");
        }
    }

    public function publish(string $routingKey, array $data): void
    {
        $this->connect();

        if (!$this->connection) {
            Log::info("Event dispatched (RabbitMQ unavailable): {$routingKey}", $data);
            return;
        }

        try {
            $channel = $this->connection->channel();
            $channel->exchange_declare($this->exchange, 'topic', false, true, false);

            $message = new AMQPMessage(json_encode([
                'event' => $routingKey,
                'payload' => $data,
                'timestamp' => now()->toIso8601String(),
            ]), [
                'content_type' => 'application/json',
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
            ]);

            $channel->basic_publish($message, $this->exchange, $routingKey);
            $channel->close();
        } catch (\Throwable $e) {
            Log::warning("RabbitMQ publish failed: {$e->getMessage()}");
        }
    }

    public function __destruct()
    {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}

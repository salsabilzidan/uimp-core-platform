<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Illuminate\Support\Facades\Log;

class ConsumeRabbitMQEvents extends Command
{
    protected $signature = 'rabbitmq:consume {queue=uimp_events_queue} {--timeout=0}';
    protected $description = 'Consume events from RabbitMQ exchange';

    public function handle()
    {
        $queue = $this->argument('queue');
        $timeout = (int) $this->option('timeout');
        $exchange = env('RABBITMQ_EXCHANGE', 'uimp_events');

        try {
            $connection = new AMQPStreamConnection(
                host: env('RABBITMQ_HOST', '127.0.0.1'),
                port: env('RABBITMQ_PORT', 5672),
                user: env('RABBITMQ_USER', 'guest'),
                password: env('RABBITMQ_PASSWORD', 'guest'),
                vhost: env('RABBITMQ_VHOST', '/'),
            );

            $channel = $connection->channel();
            $channel->exchange_declare($exchange, 'topic', false, true, false);
            $channel->queue_declare($queue, false, true, false, false);
            $channel->queue_bind($queue, $exchange, '#');

            $this->info("Listening on queue: {$queue} (exchange: {$exchange})");

            $callback = function (AMQPMessage $msg) {
                $this->info("Received: {$msg->body}");
                $msg->ack();
            };

            $channel->basic_qos(null, 1, null);
            $channel->basic_consume($queue, '', false, false, false, false, $callback);

            while ($channel->is_consuming()) {
                $channel->wait(timeout: $timeout ?: 0);
            }

            $channel->close();
            $connection->close();
        } catch (\Exception $e) {
            $this->error("RabbitMQ connection failed: {$e->getMessage()}");
            Log::warning("RabbitMQ consumer failed: {$e->getMessage()}");
            return 1;
        }

        return 0;
    }
}

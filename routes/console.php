<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('rabbitmq:consume', function () {
    $this->call(\App\Console\Commands\ConsumeRabbitMQEvents::class);
})->purpose('Consume events from RabbitMQ');

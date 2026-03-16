<?php

namespace App\Console\Commands;

use App\Services\RabbitConsumer;
use Illuminate\Console\Command;
use App\Services\RabbitMqConsumer;

class ConsumePatientCreated extends Command
{
    protected $signature = 'rabbitmq:consume-patient-created';
    protected $description = 'Consume messages from patient.created queue';

    public function handle()
    {
        $consumer = new RabbitConsumer();
        $consumer->consume();
    }
}
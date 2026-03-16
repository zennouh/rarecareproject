<?php

namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitConsumer
{
    private $connection;
    private $channel;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST', 'rabbitmq'),
            env('RABBITMQ_PORT', 5672),
            env('RABBITMQ_USER', 'guest'),
            env('RABBITMQ_PASSWORD', 'guest'),
            env('RABBITMQ_VHOST', '/')
        );

        $this->channel = $this->connection->channel();

        $this->channel->exchange_declare(
            'rarecare_events',
            'topic',
            false,
            true,
            false
        );

        $this->channel->queue_declare(
            'md_queue',
            false,
            true,
            false,
            false
        );


        $this->channel->queue_bind('md_queue', 'rarecare_events', 'maladie.created');
    }

    public function consume()
    {
        echo "Waiting for messages. To exit press CTRL+C\n";

        $callback = function (AMQPMessage $msg) {
            $data = json_decode($msg->body, true);
            echo "Received message: " . print_r($data, true) . "\n";
            CreateMD::create($data);
        };

        $this->channel->basic_consume(
            'md_queue',
            '',
            false,
            true,
            false,
            false,
            $callback
        );


        while ($this->channel->is_open()) {
            $this->channel->wait();
        }
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}

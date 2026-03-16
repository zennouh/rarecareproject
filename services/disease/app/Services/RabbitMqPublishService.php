<?php


namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMqPublishService
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
        $this->channel->exchange_declare('rarecare_events', 'topic', false, true, false);
    }

    public function publish(string $routingKey, array $data)
    {
        $message = new AMQPMessage(
            json_encode($data),
            [
                'content_type' => 'application/json',
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
            ]
        );

        $this->channel->basic_publish($message, 'rarecare_events', $routingKey);    
    }

   
    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}

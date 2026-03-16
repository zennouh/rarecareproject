<?php



namespace App\Services;

class RabbitMq
{

    private function __construct() {}
    public static function makeMessage(array $data)
    {
        try {
            $connection = new \PhpAmqpLib\Connection\AMQPStreamConnection(
                env('RABBITMQ_HOST', 'rabbitmq'),
                env('RABBITMQ_PORT', 5672),
                env('RABBITMQ_USER', 'guest'),
                env('RABBITMQ_PASSWORD', 'guest'),
                env('RABBITMQ_VHOST', '/')
            );
            $channel = $connection->channel();


            $channel->exchange_declare('rarecare_events', 'topic', false, true, false);

            $messageBody = json_encode($data); // Mock data as before
            $message = new \PhpAmqpLib\Message\AMQPMessage($messageBody, [
                'content_type' => 'application/json',
                'delivery_mode' => \PhpAmqpLib\Message\AMQPMessage::DELIVERY_MODE_PERSISTENT,
            ]);

            $channel->basic_publish($message, 'rarecare_events', 'patient.created');

            $channel->close();
            $connection->close();
        } catch (\Throwable $e) {
            return response()->json(['error' => 'RabbitMQ Publish Error: ' . $e->getMessage()], 500);
        }
    }
}

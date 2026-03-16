<?php

namespace App\Serializer;

use App\Message\PatientCreate;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

final class RabbitMQMessageSerializer implements SerializerInterface
{
    public function decode(array $encodedEnvelope): Envelope
    {
        $body = json_decode($encodedEnvelope['body'], true);
        dd($body);
        return new Envelope(
            new PatientCreate(
                $body['data']['patientId'] ?? 1,

            ),
        );
    }

    public function encode(Envelope $envelope): array
    {
        throw new \LogicException('This serializer is for consuming only.');
    }
}

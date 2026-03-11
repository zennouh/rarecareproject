<?php

namespace App\MessageHandler;

use App\Message\Patient;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class PatientHandler
{
    public function __invoke(Patient $message)
    {
        dump("Patient created: " . $message->patientId);

    }
}

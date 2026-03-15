<?php

namespace App\MessageHandler;

use App\Message\Patient;
use App\Message\PatientCreate;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class PatientHandler
{
    public function __invoke(PatientCreate $message)
    {
        dump("Patient created: " . $message->patientId);

    }
}

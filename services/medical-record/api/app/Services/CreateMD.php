<?php

namespace App\Services;

use App\Models\MedicalRecord;

class CreateMD
{


    public static function create(array $data)
    {
        $result =  MedicalRecord::create(
            [
                'maladie_id' => $data['maladie_id'],
                'name' => $data['dossier_name'],
            ]
        );
        echo "Medical record created with ID: " . $result->id . "\n";
        // return $result;

    }
}

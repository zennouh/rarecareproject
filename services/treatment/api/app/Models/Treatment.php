<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $fillable = [
        'patient_id',
        'medication_name',
        'dosage',
        'frequency',
        'start_date',
        'end_date',
        'status',
    ];

    protected $hidden = [];
}

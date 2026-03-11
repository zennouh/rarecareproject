<?php
namespace App\Models ;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model {
    protected $fillable = [
        'name',
        'maladie_id',
        'patient_id',
        'treatement_id',
        'description',
        'pdf_path',
    ];
}

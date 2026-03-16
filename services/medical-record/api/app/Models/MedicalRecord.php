<?php
namespace App\Models ;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model {
    protected $table = 'medical_record_teable';
    protected $fillable = [
        // 'patient_id',
        // 'description',
        'name',
        'maladie_id',
        'treatement_id',
        'pdf_path',
    ];
}

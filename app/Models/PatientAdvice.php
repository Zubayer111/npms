<?php

namespace App\Models;

use App\Models\PatientsProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientAdvice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'prescription_id',
        'advice',
        'investigation',
        'disease_description',
        'clinical_diagnosis',
        'next_meeting_date',
        'next_meeting_indication',
        'guide_to_prescription',
        'created_by',
        'updated_by',
    ];

    public function patient()
    {
        return $this->belongsTo(PatientsProfile::class, 'patient_id', 'id');
    }

    public function prescription()
    {
        return $this->belongsTo(PatientPrescription::class, 'prescription_id', 'prescription_id');
    }
}

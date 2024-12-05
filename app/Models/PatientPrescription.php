<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientPrescription extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'patient_id_reading',
        'parameter_id',
        'parameter_value',
        'medicine_name',
        'dose',
        'cust_dose',
        'duration',
        'duration_unit',
        'instruction',
        'created_by',
        'updated_by',
    ];
}

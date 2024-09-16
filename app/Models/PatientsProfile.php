<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientsProfile extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'reference_by',
        'reference_time',
        'reference_note',
        'title',
        'first_name',
        'last_name',
        'middle_name',
        'email',
        'gender',
        'marital_status',
        'dob',
        'height',
        'weight',
        'bmi',
        'address_one',
        'address_two',
        'city',
        'state',
        'zipCode',
        'phone_number',
        'history',
        'employer_details',
        'economical_status',
        'smoking_status',
        'blood_group',
        'alcohole_status',
        'status',
        'patient_type ',
        'profile_photo',
    ];

    protected $casts = [
        'reference_time' => 'datetime',
        'dob' => 'datetime',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

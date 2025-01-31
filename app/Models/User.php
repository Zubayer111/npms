<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'type',
        'status',
        'otp',
    ];

    protected $attributes = [
        'otp' => 0,
    ];

    // protected $hidden = [
    //     'password',
    //     'otp',
    // ];

    // public function admin()
    // {
    //     return $this->hasOne(Admin::class);
    // }
    // public function doctor()
    // {
    //     return $this->hasOne(Admin::class);
    // }
    // public function patient()
    // {
    //     return $this->hasOne(Admin::class);
    // }
    public function patientProfile()
    {
        return $this->hasOne(PatientsProfile::class, 'user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Loggable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class User extends Authenticatable
{
    use LogsActivity;
    use HasFactory, SoftDeletes , Notifiable;

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


    protected $hidden = [
        'password',
    ];

    public function getActivitylogOptions(): LogOptions
{
    $loginUser = Auth::user();

    return LogOptions::defaults()
        ->setDescriptionForEvent(fn (string $eventName) => 
            "User has been {$eventName} by " . ($loginUser ? ($loginUser->name ?? $loginUser->phone) : 'Patient')
        )
        ->logFillable()
        ->logOnlyDirty()
        ->useLogName('User Related')
        ->logExcept(['password', 'otp']);
}

    public function patientProfile()
    {
        return $this->hasOne(PatientsProfile::class, 'user_id');
    }
}

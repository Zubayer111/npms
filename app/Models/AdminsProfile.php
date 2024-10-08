<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminsProfile extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'ref_id',
        'title',
        'first_name',
        'last_name',
        'middle_name',
        'phone_number',
        'address_one',
        'address_two',
        'city',
        'state',
        'zip_code',
        'profile_photo',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientIllnesHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'disease_id',
        'patient_id',
        'status',
        'created_by',
        'updated_by'
    ];
    public function disease()
    {
        return $this->belongsTo(Diseases::class, 'disease_id');
    }
}

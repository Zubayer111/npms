<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'file_type',
        'file_name',
        'file_extension',
        'asset_path',
        'uploaded_by',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medicine extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'medicine_name',
        'user_id',
        'manufacturer_id',
        'brand_id',
        'type_id',
        'group_id',
        'strength',
        'description',
        'price',
        'use_for',
        'status',
        'created_by',
        'updated_by',
    ];

    public function group()
    {
        return $this->belongsTo(MedicineGroup::class, 'group_id');
    }

    public function type()
    {
        return $this->belongsTo(MedicineType::class, 'type_id');
    }

    public function brand()
    {
        return $this->belongsTo(User::class, 'brand_id');
    }

    public function manufacturer()
    {
        return $this->belongsTo(User::class, 'manufacturer_id');
    }
}

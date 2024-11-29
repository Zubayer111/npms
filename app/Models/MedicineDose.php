<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineDose extends Model
{
    protected $table = 'tbl_medicine_dose';
    public $timestamps = false;
    use HasFactory;
}

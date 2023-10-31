<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'patient_id',
        'doctor_id',
        'chamber_id',
        'datetime'
    ];
}

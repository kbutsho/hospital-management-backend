<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorFee extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['doctor_id', 'fee'];
    // public function doctor()
    // {
    //     return $this->belongsTo(Doctor::class);
    // }
}
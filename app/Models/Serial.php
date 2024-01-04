<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Serial extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'phone', 'age', 'address', 'doctor_id', 'department_id', 'schedule_id', 'date', 'day', 'opening_time', 'closing_time'];
}

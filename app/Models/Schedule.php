<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['doctor_id', 'chamber_id', 'day',  'status', 'opening_time', 'closing_time'];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id');
    }
    public function serial()
    {
        return $this->hasOne(Serial::class);
    }

    public function chamber()
    {
        return $this->belongsTo(Chamber::class);
    }
}

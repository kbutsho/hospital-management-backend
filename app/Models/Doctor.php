<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['user_id', 'name', 'bmdc_id', 'designation', 'department_id'];

    // public function chambers()
    // {
    //     return $this->hasMany(Chamber::class, 'doctor_id', 'id');
    // }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function serials()
    {
        return $this->hasMany(Serial::class);
    }
}

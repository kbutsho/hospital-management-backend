<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'status', 'photo', 'description'];

    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'department_id', 'id');
    }
    public function serials()
    {
        return $this->hasMany(Serial::class);
    }
}
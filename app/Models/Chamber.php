<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chamber extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['room', 'status'];

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'chamber_id', 'id');
    }
}
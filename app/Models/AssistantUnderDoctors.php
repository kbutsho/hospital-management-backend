<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssistantUnderDoctors extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['assistant_id', 'doctor_id', 'chamber_id'];
}

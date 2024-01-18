<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assistant extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['user_id', 'name',  'address', 'age', 'gender'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    // public function chamber()
    // {
    //     return $this->belongsTo(Chamber::class, 'chamber_id', 'id');
    // }
}

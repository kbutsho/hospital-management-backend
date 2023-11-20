<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'remote_host', 'remote_log', 'remote_user', 'time_stamp',
        'http_method', 'url_path', 'protocol_version', 'http_status_code',
        'bytes_sent', 'referer_url', 'user_agent', 'forwarded_info', 'status'
    ];
}

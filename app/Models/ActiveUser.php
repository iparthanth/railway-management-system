<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'ip_address',
        'user_agent',
        'current_page',
        'search_params',
        'last_activity',
    ];

    protected $casts = [
        'search_params' => 'array',
        'last_activity' => 'datetime',
    ];
}
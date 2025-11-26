<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    protected $table = 'login_attempts';

    protected $fillable = [
        'email',
        'was_successful',
        'reason',
        'ip_address',
        'user_agent',
        'occurred_at',
    ];

    protected $casts = [
        'was_successful' => 'boolean',
        'occurred_at' => 'datetime',
    ];
}

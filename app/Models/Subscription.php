<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_type',
        'status',
        'payment_method',
        'payment_status',
        'proof_path',
        'minutes_total',
        'minutes_used',
        'approved_at',
        'expires_at',
        'approved_by',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getDaysRemainingAttribute()
    {
        if ($this->plan_type === 'pro' && $this->expires_at) {
            $days = now()->diffInDays($this->expires_at, false);
            return max(0, $days);
        }
        if ($this->plan_type === 'pro' && $this->approved_at) {
            $expiresAt = $this->approved_at->copy()->addDays(30);
            $days = now()->diffInDays($expiresAt, false);
            return max(0, $days);
        }
        return null;
    }
}


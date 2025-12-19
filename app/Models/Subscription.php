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
        'price',
        'status',
        'payment_method',
        'payment_status',
        'proof_path',
        'minutes_total',
        'minutes_used',
        'approved_at',
        'expires_at',
        'approved_by',
        'support_priority',
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
        if ($this->expires_at) {
            $days = now()->diffInDays($this->expires_at, false);
            return max(0, $days);
        }
        
        // Fallback for older trial logic if still needed, but primarily we use expires_at now
        if ($this->plan_type === 'free_trial' && $this->approved_at) {
             $expiresAt = $this->approved_at->copy()->addDays(7); // Old trial logic
             $days = now()->diffInDays($expiresAt, false);
             return max(0, $days);
        }

        return null;
    }
}


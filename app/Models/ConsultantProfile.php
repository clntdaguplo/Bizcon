<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultantProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'address', 'age', 'sex', 'resume_path', 'avatar_path', 'is_verified',
        'rules_accepted', 'full_name', 'phone_number', 'email', 'expertise',
        'is_rejected', 'admin_note', 'rejected_at', 'resubmitted_at', 'resubmission_count',
        'google_token', 'suspended_until', 'has_pending_update', 'update_requested_at', 'previous_values',
    ];

    protected $casts = [
        'rejected_at' => 'datetime',
        'resubmitted_at' => 'datetime',
        'suspended_until' => 'datetime',
        'update_requested_at' => 'datetime',
        'previous_values' => 'array',
        'has_pending_update' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function suspensionHistory()
    {
        return $this->hasMany(ConsultantSuspensionHistory::class)->orderByDesc('action_date');
    }
}



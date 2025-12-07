<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultantSuspensionHistory extends Model
{
    protected $table = 'consultant_suspension_history';

    protected $fillable = [
        'consultant_profile_id',
        'admin_id',
        'action',
        'duration',
        'suspended_until',
        'action_date',
        'reason',
    ];

    protected $casts = [
        'suspended_until' => 'datetime',
        'action_date' => 'datetime',
    ];

    public function consultantProfile(): BelongsTo
    {
        return $this->belongsTo(ConsultantProfile::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'consultant_profile_id',
        'topic',
        'details',
        'preferred_date',
        'preferred_time',
        'status',
    ];

    public function consultantProfile(): BelongsTo
    {
        return $this->belongsTo(ConsultantProfile::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}



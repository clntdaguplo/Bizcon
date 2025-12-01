<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;

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
        'scheduled_date',
        'scheduled_time',
        'meeting_link',
        'proposed_date',
        'proposed_time',
        'proposal_status',
        'consultation_summary',
        'recommendations',
        'client_readiness_rating',
        'report_file_path',
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'scheduled_date' => 'date',
        'proposed_date' => 'date',
        'client_readiness_rating' => 'integer',
    ];

    public function consultantProfile(): BelongsTo
    {
        return $this->belongsTo(ConsultantProfile::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(ConsultationRating::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(ConsultationNotification::class);
    }

    public function customerRating()
    {
        return $this->hasOne(ConsultationRating::class)->where('rater_type', 'customer');
    }

    public function consultantRating()
    {
        return $this->hasOne(ConsultationRating::class)->where('rater_type', 'consultant');
    }

    /**
     * Check if consultant has a conflict at the given date and time
     */
    public static function hasConflict($consultantProfileId, $date, $time, $excludeConsultationId = null)
    {
        if (!$date || !$time) {
            return false;
        }

        $query = self::where('consultant_profile_id', $consultantProfileId)
            ->where(function($q) use ($date, $time) {
                // Check scheduled consultations (if columns exist)
                if (Schema::hasColumn('consultations', 'scheduled_date') && Schema::hasColumn('consultations', 'scheduled_time')) {
                    $q->where(function($subQ) use ($date, $time) {
                        $subQ->where('scheduled_date', $date)
                             ->where('scheduled_time', $time)
                             ->whereIn('status', ['Accepted', 'Proposed']);
                    });
                }
                
                // Check proposed consultations (if columns exist)
                if (Schema::hasColumn('consultations', 'proposed_date') && Schema::hasColumn('consultations', 'proposed_time')) {
                    $q->orWhere(function($subQ) use ($date, $time) {
                        $subQ->where('proposed_date', $date)
                             ->where('proposed_time', $time)
                             ->where('proposal_status', 'pending');
                    });
                }
            });

        if ($excludeConsultationId) {
            $query->where('id', '!=', $excludeConsultationId);
        }

        return $query->exists();
    }
}



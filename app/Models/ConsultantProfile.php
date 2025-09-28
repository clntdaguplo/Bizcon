<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultantProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'address', 'age', 'sex', 'resume_path', 'is_verified',
        'rules_accepted', 'full_name', 'phone_number', 'email', 'expertise',
        'is_rejected', 'admin_note',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}



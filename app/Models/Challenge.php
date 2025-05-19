<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Challenge extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'title',
        'description',
        'category',
        'difficulty',
        'duration_days',
        'participants',
        'badge_id',
        'xp_reward',
        'status',
        'progress',
        'days_completed',
        'total_days',
        'user_id',
    ];
}

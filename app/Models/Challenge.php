<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'difficulty',
        'duration',
        'participants',
        'badge_id',
        'xp_reward',
        'status',
        'progress',
        'days_completed',
        'total_days',
    ];
}

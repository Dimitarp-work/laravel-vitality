<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'emoji',
        'title',
        'description',
        'xp',
        'duration_value',
        'duration_unit',
        'progress',
        'streak',
        'achieved',
        'user_id',
        'day_flow',

    ];

    protected $casts = [
        'achieved' => 'boolean',
        'achieved_at' => 'datetime',
        'deadline' => 'datetime',
        'notified_about_deadline' => 'boolean',
        'last_progress_date' => 'datetime',
    ];

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function progressLogs()
    {
        return $this->hasMany(GoalProgressLog::class);
    }

    // Check if goal is overdue
    public function isOverdue()
    {
        return $this->deadline && now()->gt($this->deadline) && !$this->achieved;
    }

    // Convert duration to days
    public function getDurationInDaysAttribute(): float
    {
        return match ($this->duration_unit) {
            'hours' => $this->duration_value / 24,
            'days' => $this->duration_value,
            'weeks' => $this->duration_value * 7,
            'months' => $this->duration_value * 30,
            default => 0,
        };
    }

    // Number of updates allowed (1/day)
    public function getAllowedUpdatesAttribute(): int
    {
        return max(1, floor($this->duration_in_days));
    }

    public function getXpPerUpdateAttribute(): float
    {
        return $this->xp / $this->allowed_updates;
    }

    public function getXpEarnedAttribute(): float
    {
        return $this->progressLogs()->count() * $this->xp_per_update;
    }

    public function getProgressPercentageAttribute(): float
    {
        if ($this->xp == 0) return 0;

        return round(($this->xp_earned / $this->xp) * 100, 2);
    }

    // Update goal progress
    public function addProgress($userId): bool
    {
        $today = now()->toDateString();

        // Check if already updated today
        if ($this->progressLogs()->where('user_id', $userId)->where('updated_on', $today)->exists()) {
            return false; // already updated today
        }

        // Add progress log
        $this->progressLogs()->create([
            'goal_id' => $this->id,
            'user_id' => $userId,
            'updated_on' => $today,
        ]);

        // Update progress
        $this->progress = min(100, $this->progress_percentage);
        $this->last_progress_date = now();

        if ($this->progress >= 100 && !$this->achieved) {
            $this->achieved = true;
            $this->achieved_at = now();
        }

        $this->save();

        return true;
    }

    public function getDayFlowAttribute()
    {
        return $this->progressLogs()->count();
    }

}


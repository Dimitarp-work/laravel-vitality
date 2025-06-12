<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

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
        'achieved',
        'user_id',
        'deadline',
        'notified_about_deadline',
        'last_progress_date',
        'achieved_at',
    ];

    protected $casts = [
        'achieved' => 'boolean',
        'achieved_at' => 'datetime',
        'deadline' => 'datetime',
        'notified_about_deadline' => 'boolean',
        'last_progress_date' => 'datetime',
    ];

    // Optional: automatically append these computed attributes when serializing
    protected $appends = ['streak', 'progress_percentage'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function progressLogs()
    {
        return $this->hasMany(GoalProgressLog::class);
    }

    public function isOverdue()
    {
        return $this->deadline && now()->gt($this->deadline) && !$this->achieved;
    }

    public function getDurationInDaysAttribute(): float
    {
        return match ($this->duration_unit) {
            'minutes' => $this->duration_value / (24 * 60),
            'hours' => $this->duration_value / 24,
            'days' => $this->duration_value,
            'weeks' => $this->duration_value * 7,
            'months' => $this->duration_value * 30,
            default => 0,
        };
    }

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
        if ($this->xp == 0) {
            return 0;
        }

        return round(($this->xp_earned / $this->xp) * 100, 2);
    }

    public function addProgress($userId): bool
    {
        $today = now()->toDateString();

        if ($this->progressLogs()->where('user_id', $userId)->where('updated_on', $today)->exists()) {
            return false;
        }

        $this->progressLogs()->create([
            'goal_id' => $this->id,
            'user_id' => $userId,
            'updated_on' => $today,
        ]);

        $this->progress = min(100, $this->progress_percentage);
        $this->last_progress_date = now();

        if ($this->progress >= 100 && !$this->achieved) {
            $this->achieved = true;
            $this->achieved_at = now();
        }

        $this->save();

        return true;
    }

    /**
     * Calculate the current streak (consecutive days of progress) for this goal.
     *
     * @return int
     */
    public function getStreakAttribute(): int
    {
        $logs = $this->progressLogs()
            ->where('user_id', $this->user_id ?? auth()->id())
            ->orderBy('updated_on', 'desc')
            ->pluck('updated_on')
            ->map(fn($date) => Carbon::parse($date)->startOfDay());

        if ($logs->isEmpty()) {
            return 0;
        }

        $streak = 0;
        $currentDate = now()->startOfDay();

        foreach ($logs as $logDate) {
            if ($logDate->equalTo($currentDate)) {
                $streak++;
                $currentDate->subDay();
            } elseif ($logDate->equalTo($currentDate->copy()->subDay())) {
                $streak++;
                $currentDate->subDay();
            } else {
                break;
            }
        }

        return $streak;
    }
}

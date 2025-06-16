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

    // Append only streak and progress_percentage, with progress_percentage recalculated without XP
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

    // Recalculate progress_percentage purely based on progressLogs count vs allowed updates
    public function getProgressPercentageAttribute(): float
    {
        $totalUpdates = $this->allowed_updates;

        if ($totalUpdates == 0) {
            return 0;
        }

        $completedUpdates = $this->progressLogs()->count();

        return round(min(1, $completedUpdates / $totalUpdates) * 100, 2);
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

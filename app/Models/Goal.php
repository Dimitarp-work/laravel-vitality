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

    // Check if goal is overdue
    public function isOverdue()
    {
        return $this->deadline && now()->gt($this->deadline) && !$this->achieved;
    }
}


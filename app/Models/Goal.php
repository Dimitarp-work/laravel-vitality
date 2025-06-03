<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
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
        'achieved_at',
        'user_id',
    ];

    protected $casts = [
        'achieved' => 'boolean',
        'achieved_at' => 'datetime',
    ];

    protected $dates = ['deadline'];

    public function isOverdue()
    {
        return $this->deadline && now()->gt($this->deadline) && !$this->achieved;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

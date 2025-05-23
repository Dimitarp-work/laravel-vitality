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
        'progress',
        'streak',
        'achieved',
        'achieved_at',
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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    protected $fillable = [
        'user_id',
        'reminder_interval', // in minutes
        'is_enabled',
        'last_notification_at'
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'last_notification_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

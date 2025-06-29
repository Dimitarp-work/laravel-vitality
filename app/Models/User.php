<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'xp',
        'credits',
        'level',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationships

    public function challenges(): HasMany
    {
        return $this->hasMany(Challenge::class);
    }

    public function joinedChallenges(): BelongsToMany
    {
        return $this->belongsToMany(Challenge::class, 'challenge_user')
            ->withPivot(['days_completed', 'completed', 'joined_at'])
            ->withTimestamps();
    }

    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class);
    }

    public function reminders(): HasMany
    {
        return $this->hasMany(Reminder::class);
    }

    public function notificationSettings(): HasOne
    {
        return $this->hasOne(NotificationSetting::class);
    }

    public function stampcard(): HasOne
    {
        return $this->hasOne(Stampcard::class, 'user_id', 'id');
    }

    public function xpLogs(): HasMany
    {
        return $this->hasMany(XPLog::class);
    }
    public function diaryEntries(): HasMany
    {
        return $this->hasMany(DiaryEntry::class);
    }

public function activeBadge()
{
    return $this->belongsTo(\App\Models\Badge::class, 'active_badge_id');
}



    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class)->withTimestamps();
    }

    public function activeBanner()
{
    return $this->belongsTo(StoreItem::class, 'active_banner_id');
}

public function activeTitle()
{
    return $this->belongsTo(StoreItem::class, 'active_title_id');
}

public function banner()
{
    return $this->belongsTo(Banner::class);
}

public function banners()
{
    return $this->belongsToMany(Banner::class)->withTimestamps();
}
}


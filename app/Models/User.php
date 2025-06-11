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

    public function challenges(): HasMany
    {
        return $this->hasMany(Challenge::class);
    }

    public function joinedChallenges(): BelongsToMany
    {
        return $this->belongsToMany(Challenge::class, 'challenge_user')
            // this is needed because pivot tables aren't full models by default - have to tell laravel what extra fields I need
            ->withPivot(['days_completed', 'completed', 'joined_at']) // when you fetch the relationship, also include these extra columns from the pivot table
            ->withTimestamps();
    }


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
    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    /**
     * Get the reminders for the user.
     */
    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }

    public function notificationSettings()
    {
        return $this->hasOne(NotificationSetting::class);
    }

    public function stampcard(): HasOne
    {
        return $this->hasOne(Stampcard::class, 'user_id', 'id');
    }

    public function xpLogs()
    {
        return $this->hasMany(XPLog::class);
    }

    public function diaryEntries()
    {
        return $this->hasMany(DiaryEntry::class);
    }

}

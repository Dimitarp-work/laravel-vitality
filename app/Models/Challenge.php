<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Challenge extends Model
{
    use HasFactory;

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'challenge_user')
            // this is needed because pivot tables aren’t full models by default - have to tell laravel what extra fields I need
            ->withPivot(['days_completed', 'completed', 'joined_at']) // when you fetch the relationship, also include these extra columns from the pivot table
            ->withTimestamps();
    }

    public function isExpired(): bool
    {
        return now()->greaterThanOrEqualTo($this->start_date->copy()->addDays($this->duration_days));
    }



    protected $fillable = [
        'title',
        'description',
        'category',
        'difficulty',
        'duration_days',
        'badge_id',
        'xp_reward',
        'status',
        'start_date',
        'creator_id',
    ];

    // always behaves like a Carbon instance, so i can edit the date
    protected $casts = [
        'start_date' => 'date',
    ];

}

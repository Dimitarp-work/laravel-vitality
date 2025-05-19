<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stampcard extends Model
{
    use HasFactory;

    protected $primary_key = "user_id";

    protected $fillable = ['user_id'];

    public function dailyCheckins() : HasMany{
        return $this->hasMany(DailyCheckIn::class);
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiaryEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'mood',
        'emotions',
        'thoughts',
        'gratitude',
        'activities',
        'tags',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyCheckIn extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'isComplete',
        'stampcard_id'
    ];

    protected $casts = [
        'isComplete' => 'boolean'
    ];

    public function stampcard(): BelongsTo{
        return $this->belongsTo(Stampcard::class, 'stampcard_id');
    }
}

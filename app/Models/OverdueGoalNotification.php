<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OverdueGoalNotification extends Model
{
    use HasFactory;

    // The table name (optional if following Laravel conventions)
    protected $table = 'overdue_goal_notifications';

    // Mass assignable fields
    protected $fillable = [
        'user_id',
        'goal_id',
        'message',
    ];

    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }
}

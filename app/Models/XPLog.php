<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XPLog extends Model
{
    use HasFactory;

    protected $table = 'xp_logs'; 

    protected $fillable = ['user_id', 'xp_change', 'credit_change', 'reason'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

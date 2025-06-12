<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;
    protected $fillable = ['chat_id', 'sender', 'message', 'read_at'];
    public function chat() { return $this->belongsTo(Chat::class); }

    // Scope for unread Capy messages
    public function scopeUnreadCapy($query)
    {
        return $query->where('sender', 'capy')->whereNull('read_at');
    }
} 
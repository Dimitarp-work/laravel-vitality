<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\Mood;
use App\Services\GeminiService;

class CapyChatController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        // Get or create chat for this user
        $chat = Chat::firstOrCreate(['user_id' => $user->id]);
        $messages = $chat->messages()->orderBy('created_at')->get();

        // If chat is new, add the last Gemini mood message as Capy's first message
        if ($messages->count() === 0) {
            $lastMood = Mood::where('user_id', $user->id)->orderBy('date', 'desc')->first();
            if ($lastMood && $lastMood->message) {
                ChatMessage::create([
                    'chat_id' => $chat->id,
                    'sender' => 'capy',
                    'message' => $lastMood->message,
                ]);
                $messages = $chat->messages()->orderBy('created_at')->get();
            }
        }

        // Find the first unread Capy message
        $firstUnread = $chat->messages()->unreadCapy()->orderBy('created_at')->first();
        $firstUnreadId = $firstUnread ? $firstUnread->id : null;

        // Mark all unread Capy messages as read
        $chat->messages()->unreadCapy()->update(['read_at' => now()]);

        return view('capychat', [
            'chat' => $chat,
            'messages' => $messages,
            'firstUnreadId' => $firstUnreadId,
        ]);
    }

    public function message(Request $request)
    {
        $request->validate(['message' => 'required|string']);
        $user = Auth::user();
        $chat = Chat::firstOrCreate(['user_id' => $user->id]);
        // Save user message
        $userMsg = ChatMessage::create([
            'chat_id' => $chat->id,
            'sender' => 'user',
            'message' => $request->message,
        ]);
        // Get Gemini reply
        $gemini = new GeminiService();
        $history = $chat->messages()->orderBy('created_at')->get()->pluck('message')->toArray();
        $reply = $gemini->chatReply($user->name, $history, $request->message);
        // Save Capy reply
        $capyMsg = ChatMessage::create([
            'chat_id' => $chat->id,
            'sender' => 'capy',
            'message' => $reply,
        ]);
        return response()->json([
            'user' => $userMsg,
            'capy' => $capyMsg,
        ]);
    }

    // Endpoint to get unread Capy message count
    public function unreadCount(Request $request)
    {
        $user = Auth::user();
        $chat = Chat::firstOrCreate(['user_id' => $user->id]);
        $count = $chat->messages()->unreadCapy()->count();
        return response()->json(['count' => $count]);
    }

    // Mark a Capy message as read by ID (AJAX)
    public function markRead(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $user = Auth::user();
        $msg = \App\Models\ChatMessage::where('id', $request->id)
            ->whereHas('chat', function($q) use ($user) { $q->where('user_id', $user->id); })
            ->where('sender', 'capy')
            ->first();
        if ($msg) {
            $msg->read_at = now();
            $msg->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }
} 
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mood;
use App\Services\GeminiService;

class MoodController extends Controller
{
    // Predefined fallback messages for each mood
    private $fallbackMessages = [
        'happy' => [
            "Keep smiling, your positivity is contagious!",
            "Happiness looks great on you!",
            "Enjoy this wonderful day!",
            "Your joy is inspiring!",
            "Keep spreading good vibes!"
        ],
        'calm' => [
            "Peaceful moments are precious. Enjoy them!",
            "Calmness brings clarity. Savor it!",
            "You are a sea of tranquility today.",
            "Let your calm energy guide you.",
            "Embrace the serenity you feel."
        ],
        'neutral' => [
            "It's okay to have a neutral day. Take it easy!",
            "Every day doesn't have to be extraordinary.",
            "Balance is a good thing.",
            "Sometimes, just being is enough.",
            "Stay open to whatever the day brings."
        ],
        'stressed' => [
            "Take a deep breath. You've got this!",
            "Remember to take breaks and care for yourself.",
            "Stress is temporary. You are strong.",
            "Be kind to yourself today.",
            "You're doing better than you think."
        ],
        'sad' => [
            "It's okay to feel sad. You're not alone.",
            "Sending you a virtual hug.",
            "Take time for yourself today.",
            "Better days are ahead.",
            "You are stronger than you know."
        ],
    ];

    // Store the user's mood for today
    public function store(Request $request)
    {
        // Validate the request: mood must be one of the allowed values
        $validated = $request->validate([
            'mood' => 'required|in:happy,calm,neutral,stressed,sad',
        ]);

        $user = Auth::user();
        $today = now()->toDateString();
        $mood = $validated['mood'];
        $firstName = explode(' ', trim($user->name))[0] ?? '';

        // Get moods for this week (Mon-Sun)
        $startOfWeek = now()->startOfWeek();
        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $weekMoods = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i)->toDateString();
            $entry = Mood::where('user_id', $user->id)->where('date', $date)->first();
            $weekMoods[$days[$i]] = $entry->mood ?? null;
        }

        // Try Gemini first, fallback to template if it fails
        $messageWithName = null;
        $isGemini = false;
        try {
            $gemini = new GeminiService();
            $messageWithName = $gemini->generateSupportiveMessage($firstName, $mood, $weekMoods);
            $isGemini = true;
        } catch (\Exception $e) {
            \Log::error('Gemini API error: ' . $e->getMessage(), [
                'exception' => $e,
            ]);
            // Fallback to random template
            $message = collect($this->fallbackMessages[$mood])->random();
            $punct = preg_match('/[.!?]$/', $message, $matches) ? $matches[0] : '';
            $baseMessage = $punct ? mb_substr($message, 0, -1) : $message;
            $messageWithName = $baseMessage . ', ' . $firstName . $punct;
            $isGemini = false;
        }

        // Update or create the mood for today (so user can only have one mood per day)
        $moodEntry = Mood::updateOrCreate(
            [
                'user_id' => $user->id,
                'date' => $today,
            ],
            [
                'mood' => $mood,
                'message' => $messageWithName,
            ]
        );

        // Add the Gemini message to Capy chat
        $chat = \App\Models\Chat::firstOrCreate(['user_id' => $user->id]);
        \App\Models\ChatMessage::create([
            'chat_id' => $chat->id,
            'sender' => 'capy',
            'message' => $messageWithName,
        ]);

        // Return the message (for frontend to display)
        return response()->json([
            'success' => true,
            'mood' => $mood,
            'message' => $messageWithName,
            'today_message_is_gemini' => $isGemini,
        ]);
    }

    public function week()
    {
        $user = Auth::user();
        // Get start (Monday) and end (Sunday) of the current week
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
        $today = now()->toDateString();

        // Fetch moods for this user in the current week
        $moods = Mood::where('user_id', $user->id)
            ->whereBetween('date', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])
            ->get()
            ->keyBy('date');

        // Build array for each day of the week
        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $result = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i)->toDateString();
            $result[$days[$i]] = $moods[$date]->mood ?? null;
        }

        // Get today's supportive message if it exists
        $todayMessage = $moods[$today]->message ?? null;
        // Determine if today's message is from Gemini or fallback
        $todayMood = $moods[$today]->mood ?? null;
        $isGemini = false;
        if ($todayMessage && $todayMood && isset($this->fallbackMessages[$todayMood])) {
            // Remove the user's name from the fallback message for comparison
            $fallbacks = collect($this->fallbackMessages[$todayMood])->map(function($msg) use ($user) {
                $firstName = explode(' ', trim($user->name))[0] ?? '';
                // Remove any trailing punctuation and add possible name
                $msgBase = preg_replace('/[.!?]$/', '', $msg);
                return [
                    $msg,
                    $msgBase,
                    $msgBase . ', ' . $firstName . '.',
                    $msgBase . ', ' . $firstName . '!',
                    $msgBase . ', ' . $firstName . '?',
                    $msgBase . ', ' . $firstName,
                ];
            })->flatten()->unique()->toArray();
            $isGemini = !in_array($todayMessage, $fallbacks);
        }
        return response()->json([
            'week' => $result,
            'today_message' => $todayMessage,
            'today_message_is_gemini' => $isGemini,
        ]);
    }
}

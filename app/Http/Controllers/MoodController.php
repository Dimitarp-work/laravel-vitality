<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mood;

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

        // Pick a random fallback message for the selected mood
        $message = collect($this->fallbackMessages[$mood])->random();

        // Get the user's first name (first word of their name)
        $firstName = explode(' ', trim($user->name))[0] ?? '';
        // Insert the first name before the original punctuation (if any)
        $punct = preg_match('/[.!?]$/', $message, $matches) ? $matches[0] : '';
        $baseMessage = $punct ? mb_substr($message, 0, -1) : $message;
        $messageWithName = $baseMessage . ', ' . $firstName . $punct;

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

        // Return the message (for frontend to display)
        return response()->json([
            'success' => true,
            'mood' => $mood,
            'message' => $messageWithName,
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

        return response()->json([
            'week' => $result,
            'today_message' => $todayMessage,
        ]);
    }
}

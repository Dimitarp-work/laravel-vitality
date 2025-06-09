<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reminder;
use App\Models\Goal;
use App\Models\Challenge;
use App\Models\DailyCheckIn;
use Illuminate\Support\Facades\Auth;

class RemindersController extends Controller
{
    /**
     * Display the reminders page.
     */
    public function index(Request $request)
    {
        $type = $request->query('type');
        $user = auth()->user();
        $query = $user->reminders();

        // Get all reminders for counting (including completed ones)
        $allReminders = $query->get();
        $totalRemindersCount = $allReminders->count();
        $completedRemindersCount = $allReminders->where('is_completed', true)->count();

        // Filter out completed reminders for display
        $query->where('is_completed', false);

        if ($type) {
            $query->where('type', $type);
        }

        $reminders = $query->get();

        // Load related entities
        foreach ($reminders as $reminder) {
            switch ($reminder->type) {
                case 'goal':
                    $reminder->relatedEntity = Goal::find($reminder->entity_id);
                    break;
                case 'challenge':
                    $reminder->relatedEntity = Challenge::find($reminder->entity_id);
                    break;
                case 'daily_checkin':
                    $reminder->relatedEntity = DailyCheckIn::find($reminder->entity_id);
                    break;
            }
        }

        // Group reminders by type for the "All" view
        $groupedReminders = $reminders->groupBy('type');

        // Calculate counts per type (including completed ones)
        $typeCounts = [];
        foreach ($allReminders->groupBy('type') as $typeKey => $typeReminders) {
            $typeCounts[$typeKey] = [
                'total' => $typeReminders->count(),
                'completed' => $typeReminders->where('is_completed', true)->count()
            ];
        }

        return view('reminders.index', compact('reminders', 'type', 'groupedReminders', 'totalRemindersCount', 'completedRemindersCount', 'typeCounts'));
    }

    /**
     * Show the form for creating a new reminder.
     */
    public function create()
    {
        $userId = Auth::id();

        // Get all existing reminders for the user
        $existingReminders = Reminder::where('user_id', $userId)->get();

        // Extract IDs of entities that already have reminders
        $existingGoalIds = $existingReminders->where('type', 'goal')->pluck('entity_id')->toArray();
        $existingChallengeIds = $existingReminders->where('type', 'challenge')->pluck('entity_id')->toArray();
        $existingDailyCheckInIds = $existingReminders->where('type', 'daily_checkin')->pluck('entity_id')->toArray();

        // Fetch goals, challenges, and daily check-ins, excluding those that already have reminders
        $goals = Goal::where('user_id', $userId)->whereNotIn('id', $existingGoalIds)->get();
        $challenges = Auth::user()->joinedChallenges->whereNotIn('id', $existingChallengeIds);
        $dailyCheckIns = DailyCheckIn::where('stampcard_id', $userId)->whereNotIn('id', $existingDailyCheckInIds)->get();

        return view('reminders.create', compact('goals', 'challenges', 'dailyCheckIns'));
    }

    /**
     * Store a newly created reminder in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'goals' => 'nullable|array',
            'goals.*' => 'exists:goals,id',
            'challenges' => 'nullable|array',
            'challenges.*' => 'exists:challenges,id',
            'daily_checkins' => 'nullable|array',
            'daily_checkins.*' => 'exists:daily_check_ins,id',
        ]);

        $userId = Auth::id();

        if (!empty($request->goals)) {
            foreach ($request->goals as $goalId) {
                Reminder::create([
                    'user_id' => $userId,
                    'type' => 'goal',
                    'entity_id' => $goalId,
                    'is_completed' => false,
                ]);
            }
        }

        if (!empty($request->challenges)) {
            foreach ($request->challenges as $challengeId) {
                Reminder::create([
                    'user_id' => $userId,
                    'type' => 'challenge',
                    'entity_id' => $challengeId,
                    'is_completed' => false,
                ]);
            }
        }

        if (!empty($request->daily_checkins)) {
            foreach ($request->daily_checkins as $dailyCheckInId) {
                Reminder::create([
                    'user_id' => $userId,
                    'type' => 'daily_checkin',
                    'entity_id' => $dailyCheckInId,
                    'is_completed' => false,
                ]);
            }
        }

        return redirect()->route('reminders.index')->with('success', 'Reminders added successfully!');
    }

    /**
     * Update the specified reminder in storage.
     */
    public function update(Request $request, Reminder $reminder)
    {
        // Ensure the authenticated user owns this reminder
        if (Auth::id() !== $reminder->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $reminder->is_completed = $request->has('is_completed'); // Check if the checkbox is present
        $reminder->save();

        return back()->with('success', 'Reminder status updated.');
    }

    /**
     * Remove the specified reminder from storage.
     */
    public function destroy(Reminder $reminder)
    {
        $reminder->delete();

        return redirect()->route('reminders.index')->with('success', 'Reminder removed successfully!');
    }
}

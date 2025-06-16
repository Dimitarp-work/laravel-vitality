<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\GoalProgressLog;
use App\Models\OverdueGoalNotification;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Carbon;

class GoalController extends Controller
{
    public function goals(Request $request): View
    {
        $activeTab = $request->query('tab', 'current');
        $userId = auth()->id();

        $currentGoals = Goal::where('user_id', $userId)->where('achieved', false)->get();
        $achievedGoals = Goal::where('user_id', $userId)->where('achieved', true)->get();

        $recommendations = collect();

        foreach ($currentGoals as $goal) {
            $goalEndDate = $goal->created_at->copy();

            switch ($goal->duration_unit) {
                case 'minutes':
                    $goalEndDate->addMinutes($goal->duration_value);
                    break;
                case 'hours':
                    $goalEndDate->addHours($goal->duration_value);
                    break;
                case 'days':
                    $goalEndDate->addDays($goal->duration_value);
                    break;
                default:
                    $goalEndDate->addDays($goal->duration_value);
            }

            if ($goalEndDate->isPast() && $goal->progress < 100) {
                $updatedToday = $goal->progressLogs()
                    ->where('user_id', $userId)
                    ->whereDate('updated_on', now()->toDateString())
                    ->exists();

                if (!$updatedToday) {
                    $recommendations->push([
                        'message' => "Your goal '{$goal->title}' duration has passed and it's not completed yet. Please update your progress."
                    ]);
                }
            }
        }

        $notifications = OverdueGoalNotification::where('user_id', $userId)
            ->latest()
            ->get();

        $badges = [
            [
                'id' => 'mindfulness-master',
                'name' => 'Mindfulness Master',
                'emoji' => '⭐',
                'description' => 'Practice mindfulness for 7 days',
                'earned' => true,
                'earnedDate' => '2023-09-15',
                'progress' => 7,
                'maxProgress' => 7,
            ],
            [
                'id' => 'hydration-champion',
                'name' => 'Hydration Champion',
                'emoji' => '💧',
                'description' => 'Track water intake for 14 days',
                'earned' => true,
                'earnedDate' => '2023-09-19',
                'progress' => 14,
                'maxProgress' => 14,
            ],
            [
                'id' => 'gratitude-guide',
                'name' => 'Gratitude Guide',
                'emoji' => '🥹',
                'description' => 'Log gratitude for 10 days',
                'earned' => true,
                'earnedDate' => '2023-04-10',
                'progress' => 10,
                'maxProgress' => 10,
            ],
            [
                'id' => 'movement-maven',
                'name' => 'Movement Maven',
                'emoji' => '🏅',
                'description' => 'Track movement for 14 days',
                'earned' => false,
                'earnedDate' => null,
                'progress' => 6,
                'maxProgress' => 14,
            ],
            [
                'id' => 'streak-starter',
                'name' => 'Streak Starter',
                'emoji' => '🔥',
                'description' => 'Log daily for 3 days in a row',
                'earned' => false,
                'earnedDate' => null,
                'progress' => 2,
                'maxProgress' => 3,
            ],
            [
                'id' => 'mood-tracker',
                'name' => 'Mood Tracker',
                'emoji' => '😊',
                'description' => 'Track your mood for 5 days',
                'earned' => false,
                'earnedDate' => null,
                'progress' => 1,
                'maxProgress' => 5,
            ],
            [
                'id' => 'wellness-explorer',
                'name' => 'Wellness Explorer',
                'emoji' => '🧭',
                'description' => 'Try 5 different wellness activities',
                'earned' => false,
                'earnedDate' => null,
                'progress' => 0,
                'maxProgress' => 5,
            ],
            [
                'id' => 'digital-balance',
                'name' => 'Digital Balance',
                'emoji' => '📵',
                'description' => 'Stay off screens for 7 days',
                'earned' => false,
                'earnedDate' => null,
                'progress' => 3,
                'maxProgress' => 7,
            ],
        ];

        return view('goals', compact('activeTab', 'currentGoals', 'achievedGoals', 'badges', 'notifications', 'recommendations'));
    }

    public function create(): View
    {
        return view('goals.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'emoji' => 'required|string|max:2',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_value' => 'required|integer|min:1',
            'duration_unit' => 'required|in:minutes,hours,days',
        ]);

        $goal = new Goal($validated);
        $goal->user_id = auth()->id();
        $goal->save();

        return redirect()->route('goals')->with('success', 'Goal created successfully!');
    }

    public function edit(Goal $goal): View
    {
        return view('goals.edit', compact('goal'));
    }

    public function update(Request $request, Goal $goal): RedirectResponse
    {
        $validated = $request->validate([
            'emoji' => 'required|string|max:2',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_value' => 'required|integer|min:1',
            'duration_unit' => 'required|in:minutes,hours,days',
        ]);

        $goal->update($validated);

        return redirect()->route('goals')->with('success', 'Goal updated successfully!');
    }

    public function destroy(Goal $goal): RedirectResponse
    {
        $goal->delete();

        return redirect()->route('goals')->with('success', 'Goal deleted successfully!');
    }

    public function dailyUpdate(Request $request, Goal $goal): RedirectResponse
    {
        $user = auth()->user();
        $today = Carbon::today();

        $alreadyLogged = GoalProgressLog::where('goal_id', $goal->id)
            ->where('user_id', $user->id)
            ->whereDate('updated_on', $today)
            ->exists();

        if ($alreadyLogged) {
            return back()->with('error', 'You already updated this goal today.');
        }

        GoalProgressLog::create([
            'goal_id' => $goal->id,
            'user_id' => $user->id,
            'updated_on' => $today,
        ]);

        $durationInDays = match ($goal->duration_unit) {
            'minutes' => max(1, $goal->duration_value / (24 * 60)),
            'hours' => max(1, $goal->duration_value / 24),
            'days' => $goal->duration_value,
            default => 1,
        };

        $progressIncrement = 100 / $durationInDays;

        $goal->progress += $progressIncrement;
        if ($goal->progress >= 100) {
            $goal->progress = 100;
            $goal->achieved = true;
            $goal->achieved_at = now();
        }

        $goal->last_progress_date = now();
        $goal->save();

        return back()->with('success', 'Goal progress updated successfully!');
    }
}

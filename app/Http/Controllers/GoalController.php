<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\GoalProgressLog;
use App\Services\XPService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Carbon;


class GoalController extends Controller
{
    public function goals(Request $request): View
    {
        $activeTab = $request->query('tab', 'current');
        $showForm = $request->query('show_form') === '1';

        $currentGoals = Goal::where('achieved', false)->get();
        $achievedGoals = Goal::where('achieved', true)->get();

        $badges = [
            [
                'id' => 'hydration-champion',
                'name' => 'Hydration Champion',
                'icon' => '💧',
                'description' => 'Track water intake for 14 days',
                'earned' => true,
                'date' => '2023-09-19',
                'progress' => 100
            ],
            [
                'id' => 'movement-maven',
                'name' => 'Movement Maven',
                'icon' => '🏅',
                'description' => 'Track movement for 14 days',
                'earned' => false,
                'progress' => 6,
                'maxProgress' => 14
            ],
            [
                'id' => 'mindfulness-master',
                'name' => 'Mindfulness Master',
                'icon' => '⭐',
                'description' => 'Practice mindfulness for 7 days',
                'earned' => true,
                'date' => '2023-09-15',
                'progress' => 100
            ],
            [
                'id' => 'gratitude-guide',
                'name' => 'Gratitude Guide',
                'icon' => '🥹',
                'description' => 'Log gratitude for 10 days',
                'earned' => true,
                'date' => '2023-04-10',
                'progress' => 100
            ]
        ];

        return view('goals', compact('activeTab', 'currentGoals', 'achievedGoals', 'badges', 'showForm'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'emoji' => 'required|string|max:2',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'xp' => 'required|integer|min:10|max:1000',
            'duration_value' => 'required|integer|min:1',
            'duration_unit' => 'required|in:hours,days'
        ]);

        $validatedData['progress'] = 0;
        $validatedData['streak'] = 0;
        $validatedData['achieved'] = false;
        $validatedData['user_id'] = auth()->id();
        Goal::create($validatedData);

        return redirect()->route('goals')->with('success', 'Goal added successfully!');
    }

    public function update(Request $request, Goal $goal): RedirectResponse
    {
        $validated = $request->validate([
            'emoji'       => 'required|string|max:2',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'xp'          => 'required|integer|min:10|max:1000',
            'duration_value' => 'required|integer|min:1',
            'duration_unit' => 'required|in:hours,days',
        ]);

        $validatedData['user_id'] = auth()->id();


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

        $durationInDays = $goal->duration_unit === 'days' ? $goal->duration_value : 1;
        $xpPerUpdate = round($goal->xp / $durationInDays);
        $progressIncrement = 100 / $durationInDays;

        // Update progress
        $goal->progress += $progressIncrement;
        if ($goal->progress >= 100) {
            $goal->progress = 100;
            $goal->achieved = true;
            $goal->achieved_at = now();
        }
        $goal->last_progress_date = now();

        // **REMOVE THIS:**
        // $goal->day_flow = ($goal->day_flow ?? 0) + 1;

        $goal->save();

        app(XPService::class)->reward($user, $xpPerUpdate, 0, 'Goal progress update');

        // Instead of manually setting day_flow, just pass fresh from DB
        $goal->refresh(); // reload model from DB to get latest progressLogs count

        return back()->with([
            'success' => 'Goal updated and XP awarded!',
            'day_flow' => $goal->day_flow,
        ]);
    }
}

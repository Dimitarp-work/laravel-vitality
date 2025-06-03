<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GoalController extends Controller
{
    public function goals(Request $request): View
    {
        $activeTab = $request->query('tab', 'current');
        $showForm = $request->query('show_form') === '1';

        // Get only the current user's goals
        $currentGoals = Goal::where('user_id', auth()->id())
            ->where('achieved', false)
            ->get();

        $achievedGoals = Goal::where('user_id', auth()->id())
            ->where('achieved', true)
            ->get();


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
        // Double-check authentication
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to create a goal.');
        }

        $validatedData = $request->validate([
            'emoji' => 'required|string|max:2',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'xp' => 'required|integer|min:10|max:1000',
            'duration_value' => 'required|integer|min:1',
            'duration_unit' => 'required|in:hours,days'
        ]);

        // Assign the authenticated user's ID
        $validatedData['user_id'] = auth()->id();
        $validatedData['progress'] = 0;
        $validatedData['streak'] = 0;
        $validatedData['achieved'] = false;

        Goal::create($validatedData);

        return redirect()->route('goals')->with('success', 'Goal added successfully!');
    }

    public function update(Request $request, Goal $goal): RedirectResponse
    {
        // Authorization check
        if ($goal->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'emoji' => 'required|string|max:2',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'xp' => 'required|integer|min:10|max:1000',
            'duration_value' => 'required|integer|min:1',
            'duration_unit' => 'required|in:hours,days'
        ]);

        $goal->update($validated);

        return redirect()->route('goals')->with('success', 'Goal updated successfully!');
    }

    public function destroy(Goal $goal): RedirectResponse
    {
        // Authorization check
        if ($goal->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $goal->delete();
        return redirect()->route('goals')->with('success', 'Goal deleted successfully!');
    }
}

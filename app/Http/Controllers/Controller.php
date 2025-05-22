<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    function settings(): View {
        return view('settings');
    }

    function leaderboard(): View {
        return view('leaderboard');
    }

    function challenges(): View {
        return view('challenges');
    }

    function goals(Request $request): View {
        $activeTab = $request->query('tab', 'current');

        return view('goals', [
            'activeTab' => $activeTab,
            'currentGoals' => [
                [
                    'emoji' => '💧',
                    'title' => 'Stay hydrated throughout the day',
                    'description' => 'Nourish your body with water when you can',
                    'progress' => 70,
                    'streak' => 5,
                    'xp' => 15
                ],
                [
                    'emoji' => '🚶‍♀️',
                    'title' => 'Move your body in ways that feel good',
                    'description' => 'Listen to what your body needs',
                    'progress' => 45,
                    'streak' => 3,
                    'xp' => 10
                ],
                [
                    'emoji' => '🧘‍♂️',
                    'title' => 'Take moments to breathe and center yourself',
                    'description' => 'Find small pockets of calm in your day',
                    'progress' => 100,
                    'streak' => 7,
                    'xp' => 20
                ],
                [
                    'emoji' => '🍎',
                    'title' => 'Nourish your body with foods that energize you',
                    'description' => 'Honor your body\'s needs with kindness',
                    'progress' => 60,
                    'streak' => 4,
                    'xp' => 15
                ]
            ],
            'achievedGoals' => [
                [
                    'emoji' => '📚',
                    'title' => 'Make time for reading that brings you joy',
                    'description' => 'Nurture your mind with words that inspire',
                    'date' => 'May 10, 2023',
                    'xp' => 150
                ],
                [
                    'emoji' => '🏃‍♂️',
                    'title' => 'Build strength and endurance at your own pace',
                    'description' => 'Honor your body\'s journey and progress',
                    'date' => 'April 28, 2023',
                    'xp' => 200
                ],
                [
                    'emoji' => '🥗',
                    'title' => 'Prepare nourishing meals at home',
                    'description' => 'Connect with your food mindfully',
                    'date' => 'April 15, 2023',
                    'xp' => 100
                ]
            ],
            'badges' => [
                [
                    'id' => 'hydration-champion',
                    'name' => 'Hydration Champion',
                    'description' => 'Track water intake for 14 days',
                    'earned' => true,
                    'date' => '2023-09-19',
                    'progress' => 100
                ],
                [
                    'id' => 'movement-maven',
                    'name' => 'Movement Maven',
                    'description' => 'Track movement for 14 days',
                    'earned' => false,
                    'progress' => 60,
                    'maxProgress' => 14
                ],
                [
                    'id' => 'mindfulness-master',
                    'name' => 'Mindfulness Master',
                    'description' => 'Practice mindfulness for 7 days',
                    'earned' => true,
                    'date' => '2023-09-15',
                    'progress' => 100
                ],
                [
                    'id' => 'gratitude-guide',
                    'name' => 'Gratitude Guide',
                    'description' => 'Log gratitude for 10 days',
                    'earned' => true,
                    'date' => '2023-04-10',
                    'progress' => 100
                ]
            ]
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'emoji' => 'required|string|max:2',
            'xp' => 'required|integer|min:10|max:1000'
        ]);

        return redirect()->route('goals')->with('success', 'Goal added successfully!');
    }
}

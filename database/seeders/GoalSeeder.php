<?php

namespace Database\Seeders;

use App\Models\Goal;
use Illuminate\Database\Seeder;

class GoalSeeder extends Seeder
{
    public function run(): void
    {
        // System default goals
        $defaultGoals = [
            [
                'emoji' => '💧',
                'title' => 'Stay hydrated throughout the day',
                'description' => 'Nourish your body with water when you can',
                'xp' => 15,
                'duration_value' => 7,
                'duration_unit' => 'days',
                'is_default' => true
            ],
            [
                'emoji' => '🚶‍♀️',
                'title' => 'Move your body in ways that feel good',
                'description' => 'Listen to what your body needs',
                'xp' => 10,
                'duration_value' => 30,
                'duration_unit' => 'days',
                'is_default' => true
            ],
            [
                'emoji' => '🧘‍♂️',
                'title' => 'Take moments to breathe and center yourself',
                'description' => 'Find small pockets of calm in your day',
                'xp' => 20,
                'duration_value' => 1,
                'duration_unit' => 'hours',
                'is_default' => true
            ],
            [
                'emoji' => '🍎',
                'title' => 'Nourish your body with foods that energize you',
                'description' => 'Honor your body\'s needs with kindness',
                'xp' => 15,
                'duration_value' => 21,
                'duration_unit' => 'days',
                'is_default' => true
            ]
        ];

        foreach ($defaultGoals as $goalData) {
            Goal::create(array_merge($goalData, [
                'progress' => 0,
                'streak' => 0,
                'achieved' => false,
                'user_id' => null
            ]));
        }
    }
}

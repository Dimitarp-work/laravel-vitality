<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Goal;

class GoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Goal::create([
            'emoji' => '💧',
            'title' => 'Stay hydrated throughout the day',
            'description' => 'Nourish your body with water when you can',
            'progress' => 70,
            'streak' => 5,
            'xp' => 15,
            'duration_value' => 7,
            'duration_unit' => 'days',
            'achieved' => false,
        ]);

        Goal::create([
            'emoji' => '🚶‍♀️',
            'title' => 'Move your body in ways that feel good',
            'description' => 'Listen to what your body needs',
            'progress' => 45,
            'streak' => 3,
            'xp' => 10,
            'duration_value' => 30,
            'duration_unit' => 'days',
            'achieved' => false,
        ]);

        Goal::create([
            'emoji' => '🧘‍♂️',
            'title' => 'Take moments to breathe and center yourself',
            'description' => 'Find small pockets of calm in your day',
            'progress' => 100,
            'streak' => 7,
            'xp' => 20,
            'duration_value' => 1,
            'duration_unit' => 'hours',
            'achieved' => true,
            'achieved_at' => now(),
        ]);

        Goal::create([
            'emoji' => '🍎',
            'title' => 'Nourish your body with foods that energize you',
            'description' => 'Honor your body\'s needs with kindness',
            'progress' => 60,
            'streak' => 4,
            'xp' => 15,
            'duration_value' => 21,
            'duration_unit' => 'days',
            'achieved' => false,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChallengeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('challenges')->insert([
            [
                'title' => '7-Day Mindfulness',
                'description' => 'Practice mindfulness for 7 consecutive days',
                'category' => 'Mindfulness',
                'difficulty' => 'Beginner',
                'duration' => '7 days',
                'participants' => 128,
                'badge_id' => 'mindfulness-master',
                'xp_reward' => 100,
                'status' => 'available',
                'progress' => null,
                'days_completed' => null,
                'total_days' => null,
            ],
            [
                'title' => 'Hydration Hero',
                'description' => 'Track your water intake for 14 days',
                'category' => 'Hydration',
                'difficulty' => 'Intermediate',
                'duration' => '14 days',
                'participants' => 85,
                'badge_id' => 'hydration-champion',
                'xp_reward' => 150,
                'status' => 'active',
                'progress' => 30,
                'days_completed' => 4,
                'total_days' => 14,
            ],
            [
                'title' => 'Digital Detox',
                'description' => 'Spend 30 minutes each day without screens',
                'category' => 'Digital Wellness',
                'difficulty' => 'Advanced',
                'duration' => '21 days',
                'participants' => 42,
                'badge_id' => 'digital-balance',
                'xp_reward' => 200,
                'status' => 'completed',
                'progress' => null,
                'days_completed' => null,
                'total_days' => null,
            ],
            [
                'title' => 'Gratitude Journey',
                'description' => "Write 3 things you're grateful for each day",
                'category' => 'Mindfulness',
                'difficulty' => 'Beginner',
                'duration' => '10 days',
                'participants' => 156,
                'badge_id' => 'gratitude-guide',
                'xp_reward' => 125,
                'status' => 'available',
                'progress' => null,
                'days_completed' => null,
                'total_days' => null,
            ],
            [
                'title' => 'Movement Matters',
                'description' => 'Move your body for at least 15 minutes daily',
                'category' => 'Movement',
                'difficulty' => 'Intermediate',
                'duration' => '14 days',
                'participants' => 98,
                'badge_id' => 'movement-maven',
                'xp_reward' => 175,
                'status' => 'available',
                'progress' => null,
                'days_completed' => null,
                'total_days' => null,
            ],
        ]);
    }
}

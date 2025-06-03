<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChallengeSeeder extends Seeder
{
    public function run(): void
    {
        $challenges = [
            [
                'title' => '7-Day Mindfulness',
                'description' => 'Practice mindfulness for 7 consecutive days',
                'category' => 'Mindfulness',
                'difficulty' => 'Beginner',
                'duration_days' => 7,
                'badge_id' => 'mindfulness-master',
                'xp_reward' => 100,
                'start_date' => now()->addDays(3),
                'creator_id' => 1,
            ],
            [
                'title' => 'Hydration Hero',
                'description' => 'Track your water intake for 14 days',
                'category' => 'Hydration',
                'difficulty' => 'Intermediate',
                'duration_days' => 14,
                'badge_id' => 'hydration-champion',
                'xp_reward' => 150,
                'start_date' => now()->subDays(2),
                'creator_id' => 2,
            ],
            [
                'title' => 'Digital Detox',
                'description' => 'Spend 30 minutes each day without screens',
                'category' => 'Digital Wellness',
                'difficulty' => 'Advanced',
                'duration_days' => 21,
                'badge_id' => 'digital-balance',
                'xp_reward' => 200,
                'start_date' => now()->subDays(30),
                'creator_id' => 3,
            ],
            [
                'title' => 'Gratitude Journey',
                'description' => "Write 3 things you're grateful for each day",
                'category' => 'Mindfulness',
                'difficulty' => 'Beginner',
                'duration_days' => 10,
                'badge_id' => 'gratitude-guide',
                'xp_reward' => 125,
                'start_date' => now()->addDays(1),
                'creator_id' => 1,
            ],
            [
                'title' => 'Movement Matters',
                'description' => 'Move your body for at least 15 minutes daily',
                'category' => 'Movement',
                'difficulty' => 'Intermediate',
                'duration_days' => 14,
                'badge_id' => 'movement-maven',
                'xp_reward' => 175,
                'start_date' => now()->addDays(2),
                'creator_id' => 2,
            ],
        ];

        foreach ($challenges as &$challenge) {
            $start = Carbon::parse($challenge['start_date']);

            $challenge['status'] = now()->gt($start->copy()->addDays($challenge['duration_days']))
                ? 'completed'
                : (now()->gte($start) ? 'active' : 'available');
        }

        DB::table('challenges')->insert($challenges);
    }
}

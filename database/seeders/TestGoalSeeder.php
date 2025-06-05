<?php

namespace Database\Seeders;

use App\Models\Goal;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestGoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test user if none exists
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password')
            ]
        );

        // Clear existing test goals if any
        DB::table('goals')->where('title', 'LIKE', 'TEST GOAL%')->delete();

        // Create different test scenarios
        $testGoals = [
            [
                'title' => 'TEST GOAL: Overdue (1 day)',
                'description' => 'This goal was due yesterday',
                'deadline' => now()->subDay(),
                'achieved' => false,
                'emoji' => '⏰',
                'xp' => 50,
                'duration_value' => 7,
                'duration_unit' => 'days',
                'notified_about_deadline' => false,
                'user_id' => $user->id
            ],
            [
                'title' => 'TEST GOAL: Overdue (1 week)',
                'description' => 'This goal was due last week',
                'deadline' => now()->subWeek(),
                'achieved' => false,
                'emoji' => '⚠️',
                'xp' => 100,
                'duration_value' => 14,
                'duration_unit' => 'days',
                'notified_about_deadline' => false,
                'user_id' => $user->id
            ],
            [
                'title' => 'TEST GOAL: Not Due Yet',
                'description' => 'This goal has future deadline',
                'deadline' => now()->addWeek(),
                'achieved' => false,
                'emoji' => '📅',
                'xp' => 75,
                'duration_value' => 1,
                'duration_unit' => 'months',
                'notified_about_deadline' => false,
                'user_id' => $user->id
            ]
        ];

        foreach ($testGoals as $goalData) {
            Goal::create($goalData);
        }

        $this->command->info('Created 3 test goals:');
        $this->command->info('- 2 overdue goals (1 day and 1 week)');
        $this->command->info('- 1 future-dated goal');
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Goal;
use App\Models\User;

class GoalFactory extends Factory
{
    protected $model = Goal::class;

    public function definition(): array
    {
        $durationUnits = ['minutes', 'hours', 'days', 'weeks', 'months'];

        return [
            'emoji' => $this->faker->randomElement(['🎯', '🔥', '🚀', '📚', '🏃‍♂️']),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'xp' => $this->faker->numberBetween(50, 500),
            'duration_value' => $this->faker->numberBetween(1, 10),
            'duration_unit' => $this->faker->randomElement($durationUnits),
            'progress' => 0,
            'streak' => 0,
            'achieved' => false,
            'user_id' => User::factory(),
            'day_flow' => 0,
            'deadline' => now()->addDays($this->faker->numberBetween(1, 10)),
            'notified_about_deadline' => false,
            'last_progress_date' => null,
            'achieved_at' => null,
        ];
    }
}

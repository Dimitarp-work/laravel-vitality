<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DailyCheckIn>
 */
class DailyCheckInFactory extends Factory
{
    /**
     * The predefined daily check-ins that will be created each day
     */
    private $dailyCheckIns = [
        [
            'title' => 'Drink 8 glasses of water',
        ],
        [
            'title' => 'Take a 10-minute walk',
        ],
        [
            'title' => 'Practice mindful breathing',
        ],
        [
            'title' => 'Get 7-8 hours of sleep',
        ]
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $index = 0;

        // Get the current check-in data and increment index
        $checkIn = $this->dailyCheckIns[$index % count($this->dailyCheckIns)];
        $index++;

        return [
            'title' => $checkIn['title'],
            'isComplete' => false,
            'stampcard_id' => 1,
            'isRecurring' => true,
            'created_at' => now()->subDay(),
            'updated_at' => now()->subDay()
        ];
    }
}

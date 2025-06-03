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
            'description' => 'Stay hydrated throughout the day for better health',
        ],
        [
            'title' => 'Take a 10-minute walk',
            'description' => 'Get some fresh air and light exercise',
        ],
        [
            'title' => 'Practice mindful breathing',
            'description' => 'Take a moment to center yourself and reduce stress',
        ],
        [
            'title' => 'Get 7-8 hours of sleep',
            'description' => 'Maintain a healthy sleep schedule',
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
            'description' => $checkIn['description'],
            'isComplete' => false,
            'stampcard_id' => 1
        ];
    }
}

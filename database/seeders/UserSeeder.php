<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\NotificationSetting;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $usersData = [
            [
                'name' => 'Alice Example',
                'email' => 'alice@example.com',
                'password' => Hash::make('12345678'),
                'is_admin' => true,
            ],
            [
                'name' => 'Bob Writer',
                'email' => 'bob@example.com',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ],
            [
                'name' => 'Charlie Creator',
                'email' => 'charlie@example.com',
                'password' => Hash::make('12345678'),
                'is_admin' => false,
            ],
        ];

        foreach ($usersData as $userData) {
            $user = User::create($userData);

            // Create default notification settings for each seeded user
            NotificationSetting::create([
                'user_id' => $user->id,
                'reminder_interval' => 60, // Default to 60 minutes
                'is_enabled' => true,
            ]);
        }
    }
}

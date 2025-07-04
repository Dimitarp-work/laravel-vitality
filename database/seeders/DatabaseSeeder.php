<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            TagSeeder::class,
            ArticleSeeder::class,
            UserSeeder::class,
            ChallengeSeeder::class,
            DailyCheckInSeeder::class,
            BadgeSeeder:: class,
            BannerSeeder::class,
             StoreItemSeeder::class,
        ]);

        \App\Models\User::factory()->create([
    'name' => 'Admin User',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
    'xp' => 100,
    'credits' => 500,
    'level' => 5,
]);
    }
}

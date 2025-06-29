<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Stampcard;
use App\Models\DailyCheckIn;

class DailyCheckInSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a stampcard for each user
        Stampcard::insert([
            [
                'LLDate' => now(),
            ],
            [
                'LLDate' => now(),
            ],
            [
                'LLDate' => now(),
            ],
        ]);

        // Create 4 daily check-ins for each stampcard
        foreach (Stampcard::all() as $stampcard) {
            DailyCheckIn::factory(4)->create([
                'stampcard_id' => $stampcard->user_id
            ]);
        }
    }
}

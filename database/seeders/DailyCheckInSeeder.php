<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Stampcard;

class DailyCheckInSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
    }
}

<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run()
    {
        $tags = [
            'Emotional Wellbeing',
            'Gentle Movement',
            'Nourishment',
            'Rest',
            'Balance',
            'Mindfulness',
        ];

        foreach ($tags as $name) {
            Tag::firstOrCreate(['name' => $name]);
        }
    }
}


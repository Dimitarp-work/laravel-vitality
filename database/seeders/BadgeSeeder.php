<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Badge;
use App\Models\StoreItem;
use App\Models\User;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        $badge = Badge::firstOrCreate(
            ['name' => 'Wellness Seeker'],
            [
                'description' => 'Official employee badge of Syntess',
               'image_url' => '/images/syntess-badge.png',
                'style' => [
                    'bg' => 'bg-blue-500',
                    'text' => 'text-white font-semibold',
                    'icon' => 'fa-solid fa-id-badge'
                ]
            ]
        );

        StoreItem::firstOrCreate([
            'item_type' => Badge::class,
            'item_id' => $badge->id,
            'category' => 'badge',
        ], [
            'price' => 0
        ]);

        $users = User::all();
        foreach ($users as $user) {
            $user->badges()->syncWithoutDetaching([$badge->id]);

            if (!$user->active_badge_id) {
                $user->active_badge_id = $badge->id;
                $user->save();
            }
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;
use App\Models\StoreItem;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'name' => 'Sunset',
                'image_url' => 'https://images.unsplash.com/photo-1506765515384-028b60a970df',
                'price' => 400,
            ],
            [
                'name' => 'Ocean',
                'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e',
                'price' => 400,
            ],
            [
                'name' => 'Space',
                'image_url' => 'https://images.unsplash.com/photo-1446776811953-b23d57bd21aa',
                'price' => 400,
            ],
            [
                'name' => 'Forest',
                'image_url' => 'https://images.unsplash.com/photo-1470770841072-f978cf4d019e',
                'price' => 400,
            ],
        ];

        foreach ($banners as $data) {
            $banner = Banner::create([
                'name' => $data['name'],
                'image_url' => $data['image_url'],
                'price' => $data['price'],
            ]);

           StoreItem::firstOrCreate([
    'item_id' => $banner->id,
    'item_type' => \App\Models\Banner::class,
    'category' => 'banner',
], [
    'price' => $data['price'],
    'type' => 'banner',
]);
        }
    }
}

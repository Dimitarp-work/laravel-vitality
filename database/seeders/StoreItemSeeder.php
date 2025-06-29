<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StoreItem;
use App\Models\Banner;

class StoreItemSeeder extends Seeder
{
    public function run(): void
    {
        $banners = Banner::all();

        foreach ($banners as $banner) {
          StoreItem::firstOrCreate([
    'item_id' => $banner->id,
    'item_type' => \App\Models\Banner::class, 
    'category' => 'banner',
], [
    'price' => $banner->price,
    'type' => 'banner',
]);
        }
    }
}

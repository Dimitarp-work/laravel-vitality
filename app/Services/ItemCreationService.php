<?php
namespace App\Services;

use App\Models\Badge;
use App\Models\Title;
use App\Models\ProfileBanner;
use App\Models\StoreItem;

class ItemCreationService
{
    public function createBadge(array $data, float $price = 0): Badge
    {
        $badge = Badge::create($data);

        StoreItem::create([
            'item_type' => Badge::class,
            'item_id' => $badge->id,
            'category' => 'badge',
            'price' => $price,
        ]);

        return $badge;
    }

    public function createTitle(array $data, float $price = 0): Title
    {
        $title = Title::create($data);

        StoreItem::create([
            'item_type' => Title::class,
            'item_id' => $title->id,
            'category' => 'title',
            'price' => $price,
        ]);

        return $title;
    }

    public function createBanner(array $data, float $price = 0): ProfileBanner
    {
        $banner = ProfileBanner::create($data);

        StoreItem::create([
            'item_type' => ProfileBanner::class,
            'item_id' => $banner->id,
            'category' => 'banner',
            'price' => $price,
        ]);

        return $banner;
    }
}

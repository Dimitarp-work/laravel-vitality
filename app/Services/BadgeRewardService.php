<?php
namespace App\Services;

use App\Models\Badge;
use App\Models\Title;
use App\Models\ProfileBanner;
use App\Models\StoreItem;

class badgeRewardService {

public function awardBadgeToUser(int $userId, int $badgeId): void
{
    $user = \App\Models\User::findOrFail($userId);
    $badge = \App\Models\Badge::findOrFail($badgeId);

    $user->badges()->syncWithoutDetaching([$badge->id]);
}
}

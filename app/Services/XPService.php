<?php

namespace App\Services;

use App\Models\User;

class XPService
{
   public function reward(User $user, int $xp, int $credits, string $reason): void
{
    $user->increment('xp', $xp);
    $user->increment('credits', $credits);
    $user->xpLogs()->create([
        'xp_change' => $xp,
        'credit_change' => $credits,
        'reason' => $reason,
    ]);
}

    public function deductCredits(User $user, int $amount, ?string $reason = null): void
    {
        $user->decrement('credits', $amount);
        $user->xpLogs()->create([
            'xp_change' => 0,
            'credit_change' => -$amount,
            'reason' => $reason,
        ]);
    }
}

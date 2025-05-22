<?php

namespace App\Services;

use App\Models\User;
use App\Models\XPLog;

class XPService
{
    public function reward(User $user, int $xp, int $credits, string $reason): void
    {
        if ($xp > 0) {
            $user->increment('xp', $xp);
        }

        if ($credits > 0) {
            $user->increment('credits', $credits);
        }

        XPLog::create([
            'user_id' => $user->id,
            'xp_change' => $xp,
            'credit_change' => $credits,
            'reason' => $reason,
        ]);
    }

    public function deductCredits(User $user, int $amount, ?string $reason = null): void
    {
        $user->decrement('credits', $amount);

        XPLog::create([
            'user_id' => $user->id,
            'xp_change' => 0,
            'credit_change' => -$amount,
            'reason' => $reason ?? 'No reason provided',
        ]);
    }
}

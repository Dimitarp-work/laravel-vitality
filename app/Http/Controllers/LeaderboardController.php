<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function xp()
    {
        $this->updateXpSnapshot();

        // Get latest + previous snapshots per user
        $snapshots = DB::table('xp_leaderboard_snapshots')
            ->orderBy('captured_at', 'desc')
            ->get()
            ->groupBy('user_id');

        $rankHistory = [];

        foreach ($snapshots as $userId => $userSnaps) {
            $latest = $userSnaps->first();
            $previous = $userSnaps->skip(1)->first();

            $rankHistory[$userId] = [
                'previous' => $previous,
            ];
        }

        $topThree = User::orderByDesc('xp')
            ->take(3)
            ->get()
            ->map(function ($user, $index) use ($rankHistory) {
                $trend = 'same';
                $todayRank = $index + 1;
                $prevRank = $rankHistory[$user->id]['previous']->rank ?? null;

                if ($prevRank !== null) {
                    if ($todayRank < $prevRank) $trend = 'up';
                    elseif ($todayRank > $prevRank) $trend = 'down';
                }

                return array_merge($user->toArray(), ['trend' => $trend]);
            });

        $users = User::orderByDesc('xp')
            ->offset(3)
            ->limit(100)
            ->get()
            ->values()
            ->map(function ($user, $index) use ($rankHistory) {
                $trend = 'same';
                $todayRank = $index + 4;
                $prevRank = $rankHistory[$user->id]['previous']->rank ?? null;

                if ($prevRank !== null) {
                    if ($todayRank < $prevRank) $trend = 'up';
                    elseif ($todayRank > $prevRank) $trend = 'down';
                }

                return array_merge($user->toArray(), ['trend' => $trend]);
            });

        return view('leaderboard.xp', compact('topThree', 'users'));
    }

    public function badges()
    {
        $this->updateBadgeSnapshot();

        $snapshots = DB::table('badge_leaderboard_snapshots')
            ->orderBy('captured_at', 'desc')
            ->get()
            ->groupBy('user_id');

        $rankHistory = [];

        foreach ($snapshots as $userId => $userSnaps) {
            $latest = $userSnaps->first();
            $previous = $userSnaps->skip(1)->first();

            $rankHistory[$userId] = [
                'previous' => $previous,
            ];
        }

        $topThree = User::withCount('badges')
            ->orderByDesc('badges_count')
            ->take(3)
            ->get()
            ->map(function ($user, $index) use ($rankHistory) {
                $trend = 'same';
                $todayRank = $index + 1;
                $prevRank = $rankHistory[$user->id]['previous']->rank ?? null;

                if ($prevRank !== null) {
                    if ($todayRank < $prevRank) $trend = 'up';
                    elseif ($todayRank > $prevRank) $trend = 'down';
                }

                return array_merge($user->toArray(), ['trend' => $trend]);
            });

        $users = User::withCount('badges')
            ->orderByDesc('badges_count')
            ->offset(3)
            ->limit(100)
            ->get()
            ->values()
            ->map(function ($user, $index) use ($rankHistory) {
                $trend = 'same';
                $todayRank = $index + 4;
                $prevRank = $rankHistory[$user->id]['previous']->rank ?? null;

                if ($prevRank !== null) {
                    if ($todayRank < $prevRank) $trend = 'up';
                    elseif ($todayRank > $prevRank) $trend = 'down';
                }

                return array_merge($user->toArray(), ['trend' => $trend]);
            });

        return view('leaderboard.badges', compact('topThree', 'users'));
    }

    protected function updateXpSnapshot()
    {
        $now = now();
        $xpUsers = User::orderByDesc('xp')->get();

        foreach ($xpUsers as $index => $user) {
            DB::table('xp_leaderboard_snapshots')->insert([
                'user_id'      => $user->id,
                'xp'           => $user->xp,
                'rank'         => $index + 1,
                'captured_at'  => $now, // full timestamp
                'created_at'   => $now,
                'updated_at'   => $now,
            ]);
        }
    }

    protected function updateBadgeSnapshot()
    {
        $now = now();
        $badgeUsers = User::withCount('badges')->orderByDesc('badges_count')->get();

        foreach ($badgeUsers as $index => $user) {
            DB::table('badge_leaderboard_snapshots')->insert([
                'user_id'        => $user->id,
                'badges_count'   => $user->badges_count,
                'rank'           => $index + 1,
                'captured_at'    => $now,
                'created_at'     => $now,
                'updated_at'     => $now,
            ]);
        }
    }
}

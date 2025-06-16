<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LeaderboardController extends Controller
{
    public function xp()
    {
        $today = now()->toDateString();
        $yesterday = now()->subDay()->toDateString();

        // Get snapshot data grouped by user_id
        $snapshots = DB::table('xp_leaderboard_snapshots')
            ->whereIn('captured_at', [$yesterday, $today])
            ->get()
            ->groupBy('user_id');

        // Top 3 users
        $topThree = User::orderByDesc('xp')
            ->take(3)
            ->get()
            ->map(function ($user, $index) use ($snapshots, $yesterday) {
                $trend = 'same';
                $todayRank = $index + 1;

                // Only check if snapshot for user exists
                $userSnapshots = $snapshots[$user->id] ?? collect();
                $yesterdayRank = $userSnapshots->firstWhere('captured_at', $yesterday)->rank ?? null;

                if ($yesterdayRank !== null) {
                    if ($todayRank < $yesterdayRank) $trend = 'up';
                    elseif ($todayRank > $yesterdayRank) $trend = 'down';
                }

                return array_merge($user->toArray(), ['trend' => $trend]);
            });

        // The rest of the leaderboard
        $users = User::orderByDesc('xp')
            ->offset(3)
            ->limit(100)
            ->get()
            ->values()
            ->map(function ($user, $index) use ($snapshots, $yesterday) {
                $trend = 'same';
                $todayRank = $index + 4;

                $userSnapshots = $snapshots[$user->id] ?? collect();
                $yesterdayRank = $userSnapshots->firstWhere('captured_at', $yesterday)->rank ?? null;

                if ($yesterdayRank !== null) {
                    if ($todayRank < $yesterdayRank) $trend = 'up';
                    elseif ($todayRank > $yesterdayRank) $trend = 'down';
                }

                return array_merge($user->toArray(), ['trend' => $trend]);
            });

        return view('leaderboard.xp', compact('topThree', 'users'));
    }

    public function badges()
    {
        $today = now()->toDateString();
        $yesterday = now()->subDay()->toDateString();

        // Get snapshot data grouped by user_id
        $snapshots = DB::table('badge_leaderboard_snapshots')
            ->whereIn('captured_at', [$yesterday, $today])
            ->get()
            ->groupBy('user_id');

        // Top 3 users by badge count
        $topThree = User::withCount('badges')
            ->orderByDesc('badges_count')
            ->take(3)
            ->get()
            ->map(function ($user, $index) use ($snapshots, $yesterday) {
                $trend = 'same';
                $todayRank = $index + 1;

                $userSnapshots = $snapshots[$user->id] ?? collect();
                $yesterdayRank = $userSnapshots->firstWhere('captured_at', $yesterday)->rank ?? null;

                if ($yesterdayRank !== null) {
                    if ($todayRank < $yesterdayRank) $trend = 'up';
                    elseif ($todayRank > $yesterdayRank) $trend = 'down';
                }

                return array_merge($user->toArray(), ['trend' => $trend]);
            });

        // Rest of leaderboard
        $users = User::withCount('badges')
            ->orderByDesc('badges_count')
            ->offset(3)
            ->limit(100)
            ->get()
            ->values()
            ->map(function ($user, $index) use ($snapshots, $yesterday) {
                $trend = 'same';
                $todayRank = $index + 4;

                $userSnapshots = $snapshots[$user->id] ?? collect();
                $yesterdayRank = $userSnapshots->firstWhere('captured_at', $yesterday)->rank ?? null;

                if ($yesterdayRank !== null) {
                    if ($todayRank < $yesterdayRank) $trend = 'up';
                    elseif ($todayRank > $yesterdayRank) $trend = 'down';
                }

                return array_merge($user->toArray(), ['trend' => $trend]);
            });

        return view('leaderboard.badges', compact('topThree', 'users'));
    }
}

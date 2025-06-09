<?php

namespace App\Http\Controllers;

use App\Models\DailyCheckIn;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LeaderboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function xp()
    {
        $topThree = User::orderByDesc('xp')->take(3)->get();
        $users = User::orderByDesc('xp')->offset(3)->limit(100)->get(); // ✅ Works with MySQL


        return view('leaderboard.xp', compact('topThree', 'users'));
    }

}

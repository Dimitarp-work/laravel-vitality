<?php

namespace App\Http\Controllers;

use App\Models\DailyCheckIn;
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
        return view('leaderboard.xp');
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    function home(): View{
        return view('home');
    }
    function settings(): View{
        return view('settings');
    }

    function leaderboard(): View{
        return view('leaderboard');
    }

    function challenges(): View{
        return view('challenges.index');
    }
}

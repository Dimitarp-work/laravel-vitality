<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThoughtController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'thought' => 'required|string|max:1000',
        ]);

        // Reward logic
        $user = Auth::user();
        if ($user) {
            $xpService = new \App\Services\XPService();
            $xpService->reward($user, 50, 50, 'Posted a Thought');

        }

        return back()->with('success', 'Thought saved! +50 XP and +50 Credits!');
    }
}

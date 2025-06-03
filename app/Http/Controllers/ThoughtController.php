<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\XPService;

class ThoughtController extends Controller
{
    protected $xpService;

    public function __construct(XPService $xpService)
    {
        $this->xpService = $xpService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'thought' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        if ($user) {
            $this->xpService->reward($user, 50, 50, 'Posted a Thought');
        }

        return back()->with('success', 'Thought saved! +50 XP and +50 Credits!');
    }
}

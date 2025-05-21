<?php

namespace App\Http\Controllers;

use App\Models\DailyCheckIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyCheckInController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        return view('checkins.index', [
            'checkins' => DailyCheckIn::where('stampcard_id', $userId)
                ->select('id', 'title', 'isComplete')
                ->get()
        ]);
    }

    /**
     * Display the weekly view.
     */
    public function week()
    {
        return view('checkins.week');
    }

    /**
     * Display the reminders view.
     */
    public function reminders()
    {
        return view('checkins.reminders');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DailyCheckIn $dailyCheckIn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DailyCheckIn $dailyCheckIn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DailyCheckIn $dailyCheckIn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailyCheckIn $dailyCheckIn)
    {
        //
    }

    /**
     * Mark a check-in as complete.
     */
    public function complete(DailyCheckIn $dailyCheckIn)
    {
        // Add authorization check
        $userId = Auth::id();
        if ($dailyCheckIn->stampcard_id !== $userId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $dailyCheckIn->update(['isComplete' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Check-in completed successfully'
        ]);
    }
}

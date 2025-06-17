<?php

namespace App\Http\Controllers;

use App\Models\DailyCheckIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Reminder;

class DailyCheckInController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        // Get today's check-ins
        $checkins = DailyCheckIn::where('stampcard_id', $userId)
            ->whereDate('created_at', $today)
            ->select('id', 'title', 'isComplete', 'isRecurring')
            ->get();

        // If no check-ins exist for today, get recurring ones from yesterday
        if ($checkins->isEmpty()) {
            $recurringCheckins = DailyCheckIn::where('stampcard_id', $userId)
                ->whereDate('created_at', $yesterday)
                ->where('isRecurring', true)
                ->select('id', 'title', 'isComplete', 'isRecurring')
                ->get();

            // Create new check-ins based on yesterday's recurring ones
            foreach ($recurringCheckins as $recurringCheckin) {
                DailyCheckIn::create([
                    'title' => $recurringCheckin->title,
                    'isComplete' => false,
                    'stampcard_id' => $userId,
                    'isRecurring' => true
                ]);
            }

            // Get the newly created check-ins
            $checkins = DailyCheckIn::where('stampcard_id', $userId)
                ->whereDate('created_at', $today)
                ->select('id', 'title', 'isComplete', 'isRecurring')
                ->get();
        }

        return view('checkins.index', [
            'checkins' => $checkins
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
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:30',
                'isRecurring' => 'boolean'
            ]);

            $checkin = DailyCheckIn::create([
                'title' => $validated['title'],
                'isComplete' => false,
                'stampcard_id' => Auth::id(),
                'isRecurring' => $request->boolean('isRecurring', false)
            ]);

            if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Check-in created successfully',
                'checkin' => $checkin
            ]);
            }

            return redirect()->route('checkins.index')
                ->with('success', 'Check-in created successfully');

        } catch (\Exception $e) {
            if ($request->wantsJson()) {
            return response()->json([
                'success' => false,
                    'message' => $e->getMessage()
                ], $e instanceof \Illuminate\Validation\ValidationException ? 422 : 500);
            }

            return redirect()->back()
                ->withInput()
                ->withErrors(['title' => $e->getMessage()]);
        }
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
        if (!$dailyCheckIn) {
            return response()->json([
                'success' => false,
                'message' => 'Check-in not found'
            ], 404);
        }
        $userId = Auth::id();
        if ($dailyCheckIn->stampcard_id !== $userId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Delete the current check-in
        $dailyCheckIn->delete();

        // Set isRecurring to false for the same check-in from yesterday
        DailyCheckIn::where('stampcard_id', $userId)
            ->where('title', $dailyCheckIn->title)
            ->whereDate('created_at', Carbon::yesterday())
            ->update(['isRecurring' => false]);

        return redirect()->route('checkins.index')->with('success', 'Check-in deleted successfully');
    }

    /**
     * Mark a check-in as complete.
     */
    public function complete(DailyCheckIn $dailyCheckIn)
    {
        $userId = Auth::id();
        if ($dailyCheckIn->stampcard_id !== $userId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $dailyCheckIn->update(['isComplete' => true]);

        // Delete associated reminder if it exists
        Reminder::where('type', 'daily_checkin')
            ->where('entity_id', $dailyCheckIn->id)
            ->where('user_id', $userId) // Ensure it's the current user's reminder
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Check-in completed successfully'
        ]);
    }
}

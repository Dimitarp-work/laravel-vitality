<?php

namespace App\Http\Controllers;

use App\Models\DailyCheckIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DailyCheckInController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $today = Carbon::today();

        // Get today's check-ins
        $checkins = DailyCheckIn::where('stampcard_id', $userId)
            ->whereDate('created_at', $today)
            ->select('id', 'title', 'isComplete')
            ->get();

        // If no check-ins exist for today, create new ones using factory
        if ($checkins->isEmpty()) {
            // Create 4 check-ins using the factory
        DailyCheckIn::factory(4)->create([
            'stampcard_id' => $userId,
        ]);
        $checkins = DailyCheckIn::where('stampcard_id', $userId)
                ->whereDate('created_at', $today)
                ->select('id', 'title', 'isComplete')
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
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:30'
            ]);

            $checkin = DailyCheckIn::create([
                'title' => $validated['title'],
                'description' => 'Custom check-in',
                'isComplete' => false,
                'stampcard_id' => Auth::id()
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
        $userId = Auth::id();
        if ($dailyCheckIn->stampcard_id !== $userId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }
        $dailyCheckIn->delete();
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

        return response()->json([
            'success' => true,
            'message' => 'Check-in completed successfully'
        ]);
    }
}

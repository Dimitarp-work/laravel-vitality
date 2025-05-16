<?php

namespace App\Http\Controllers;

use App\Models\DailyCheckIn;
use Illuminate\Http\Request;

class DailyCheckInController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return view('checkins.index');
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
}

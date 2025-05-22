<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChallengeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $filter = $request->query('filter');

        // Determine if the filter is a status or difficulty
        $isStatusFilter = in_array($filter, ['active', 'available', 'completed']);
        $isDifficultyFilter = in_array($filter, ['Beginner', 'Intermediate', 'Advanced']);

        // Get IDs of challenges the user has already joined
        $joinedIds = $user->joinedChallenges()->pluck('challenge_id');

        // Mark all expired challenges as completed
        $expiringChallenges = Challenge::where('status', '!=', 'completed')->get();

        foreach ($expiringChallenges as $challenge) {
            if ($challenge->isExpired()) {
                $challenge->update(['status' => 'completed']);
            }
        }

        // 1. Active or Available Challenges the user joined
        $activeQuery = Challenge::with('participants')
            ->whereIn('status', ['active', 'available'])
            ->whereIn('id', $joinedIds);

        if ($isStatusFilter) {
            $activeQuery->where('status', $filter);
        }

        if ($isDifficultyFilter) {
            $activeQuery->where('difficulty', $filter);
        }

        $activeChallenges = $activeQuery->get();

        // 2. Completed Challenges the user joined
        $completedQuery = Challenge::with('participants')
            ->where('status', 'completed')
            ->whereIn('id', $joinedIds);

        if ($isDifficultyFilter) {
            $completedQuery->where('difficulty', $filter);
        }

        $completedChallenges = $completedQuery->get();

        // 3. Discoverable Available Challenges (not joined)
        $availableChallenges = collect(); // default empty

        if (!$isStatusFilter || $filter === 'available' || $isDifficultyFilter) {
            $availableQuery = Challenge::with('participants')
                ->where('status', 'available')
                ->where('start_date', '>', now())
                ->whereNotIn('id', $joinedIds);

            if ($isDifficultyFilter) {
                $availableQuery->where('difficulty', $filter);
            }

            $availableChallenges = $availableQuery->get();
        }

        return view('challenges.index', [
            'activeChallenges' => $activeChallenges,
            'completedChallenges' => $completedChallenges,
            'availableChallenges' => $availableChallenges,
            'currentFilter' => $filter,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('challenges.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'nullable|string|max:255',
            'difficulty' => 'required|in:Beginner,Intermediate,Advanced',
            'duration_days' => 'required|integer|min:1',
            'xp_reward' => 'required|integer|min:0',
            'badge_id' => 'nullable|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
        ]);

        $validated['creator_id'] = auth()->id();  // user id of the creatir
        $validated['status'] = 'available';       // initial state

        $challenge = Challenge::create($validated);

        // auto-join creator to the challenge
        $challenge->participants()->attach(auth()->id(), [
            'joined_at' => now(),
            'days_completed' => 0,
            'completed' => false,
        ]);

        return redirect()->route('challenges.index')->with('success', 'Challenge created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Challenge $challenge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Challenge $challenge)
    {
        $this->authorize('update', $challenge);

        return view('challenges.edit', compact('challenge'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Challenge $challenge)
    {
        $this->authorize('update', $challenge); //uses laravels authorization system (@can in Blade, authorize() in controller)
        //checks if the current user is allowed to update this specific $challenge.This checks ChallengePolicy@update.

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'nullable|string|max:255',
            'difficulty' => 'required|in:Beginner,Intermediate,Advanced',
            'duration_days' => 'required|integer|min:1',
            'xp_reward' => 'required|integer|min:0',
            'badge_id' => 'nullable|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
        ]);


        $challenge->update($validated); //updates the $challenge model with the validated form data

        return redirect()->route('challenges.index')->with('success', 'Challenge updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Challenge $challenge)
    {
        $this->authorize('delete', $challenge);

        $challenge->delete();

        return redirect()->route('challenges.index')->with('success', 'Challenge deleted.');
    }

    public function confirmDelete(Challenge $challenge)
    {
        $this->authorize('delete', $challenge);
        return view('challenges.confirm-delete', compact('challenge'));
    }

    public function join($challengeId)
    {
        $user = Auth::user(); // get the logged-in user
        $challenge = Challenge::findOrFail($challengeId);

        $user->joinedChallenges()->syncWithoutDetaching([
            $challenge->id => ['joined_at' => now()]
        ]);


        return redirect()->back()->with('success', 'You joined the challenge!');
    }

    public function logProgress(Request $request, Challenge $challenge)
    {
        $user = auth()->user(); // get the currently logged-in user

        // try to get the pivot row between the user and this challenge
        $pivot = $user->joinedChallenges()
            ->where('challenge_id', $challenge->id) // filter only for this challenge
            ->first() // get the first result (should only be one anyway)
            ?->pivot; // get the pivot data (extra fields like days_completed)

        if (!$pivot) {
            // user hasn't joined this challenge (this is just a protective measure, shouldnt happen)
            return back()->withErrors('You must join the challenge first.');
        }

        // stop the user from logging more than once per calendar day
        if ($pivot->updated_at->isToday()) {
            return back()->withErrors('You already logged your progress today.');
        }

        // stop the user if they've already completed the challenge
        if ($pivot->days_completed >= $challenge->duration_days) {
            return back()->withErrors('Challenge already completed.');
        }

        // if all checks pass, increase the number of days completed by 1
        $pivot->days_completed++;

        // if this was the final day, mark the challenge as completed for this user
        if ($pivot->days_completed >= $challenge->duration_days) {
            $pivot->completed = true;
        }

        // save the updated pivot data (days_completed and possibly completed)
        $pivot->save();

        // send success message back to the user
        return back()->with('success', 'Progress logged successfully!');
    }

}

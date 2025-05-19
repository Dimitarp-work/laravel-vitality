<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->query('filter');

        $query = Challenge::query();

        if (in_array($filter, ['active', 'available', 'completed'])) {
            $query->where('status', $filter);
        } elseif (in_array($filter, ['Beginner', 'Intermediate', 'Advanced'])) {
            $query->where('difficulty', $filter);
        }

        $challenges = $query->get();

        return view('challenges.index', [
            'activeChallenges' => $challenges->where('status', 'active'),
            'availableChallenges' => $challenges->where('status', 'available'),
            'completedChallenges' => $challenges->where('status', 'completed'),
            'currentFilter' => $filter
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
        ]);

        $validated['participants'] = 0;
        $validated['status'] = 'available';
        $validated['progress'] = null;
        $validated['days_completed'] = null;
        $validated['total_days'] = null;
        $validated['user_id'] = auth()->id(); // Associate with logged-in user

        Challenge::create($validated);

        return redirect()->route('challenges.index')->with('success', 'Challenge created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Article $article)
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
        $this->authorize('update', $challenge);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'nullable|string|max:255',
            'difficulty' => 'required|in:Beginner,Intermediate,Advanced',
            'duration_days' => 'required|integer|min:1',
            'xp_reward' => 'required|integer|min:0',
            'badge_id' => 'nullable|string|max:255',
        ]);

        $challenge->update($validated);

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

}

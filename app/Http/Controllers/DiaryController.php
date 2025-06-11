<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiaryEntry;

class DiaryController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'new'); // default tab = 'new'

        $pastEntries = [];

        if ($activeTab === 'past') {
            $pastEntries = DiaryEntry::where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('diary.index', compact('activeTab', 'pastEntries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mood' => 'required|string|max:5',
            'emotions' => 'required|string',
            'thoughts' => 'required|string',
            'gratitude' => 'nullable|string',
            'activities' => 'nullable|string',
            'tags' => 'nullable|string',
        ]);

        $action = $request->input('action');

        $entry = new DiaryEntry();
        $entry->mood = $validated['mood'];
        $entry->emotions = $validated['emotions'];
        $entry->thoughts = $validated['thoughts'];
        $entry->gratitude = $validated['gratitude'] ?? null;
        $entry->activities = $validated['activities'] ?? null;
        $entry->tags = $validated['tags'] ?? null;
        $entry->status = $action === 'draft' ? 'draft' : 'submitted';
        $entry->user_id = auth()->id();

        $entry->save();

        return redirect()->route('diary', ['tab' => 'past'])
            ->with('success', 'Entry saved successfully!');
    }
}

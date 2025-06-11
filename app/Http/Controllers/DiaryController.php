<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiaryEntry;

// Adjust model name if different

class DiaryController extends Controller
{
    // Show form for new diary entry
    public function create()
    {
        return view('diary.new-entry');
    }

    // Store a new diary entry (handle form POST)
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

        // You can handle draft or submit status here if you want
        $entry->status = $action === 'draft' ? 'draft' : 'submitted';

        $entry->user_id = auth()->id(); // if diary entries belong to users
        $entry->save();

        if ($action === 'draft') {
            return redirect()->route('diary.new')->with('success', 'Saved as draft.');
        } else {
            return redirect()->route('diary.entries')->with('success', 'Entry saved successfully!');
        }
    }

    public function index(Request $request)
    {
        $tab = $request->query('tab', 'all');

        $entries = auth()->user()->diaryEntries()->latest()->get();

        $favoriteEntries = $entries->where('is_favorite', true);

        return view('diary.past-reflections', [
            'activeTab' => $tab,
            'entries' => $entries,
            'favoriteEntries' => $favoriteEntries,
        ]);
    }


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiaryEntry;

class DiaryController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'new');
        $pastEntries = [];
        $draft = null;

        if ($activeTab === 'past') {
            $pastEntries = DiaryEntry::where('user_id', auth()->id())
                ->where('status', 'submitted')
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($activeTab === 'new') {
            $draft = DiaryEntry::where('user_id', auth()->id())
                ->where('status', 'draft')
                ->latest()
                ->first();
        }

        return view('diary.index', compact('activeTab', 'pastEntries', 'draft'));
    }

    public function store(Request $request)
    {
        $action = $request->input('action');

        $rules = [
            'mood' => $action === 'submit' ? 'required|string|max:5' : 'nullable|string|max:5',
            'emotions' => $action === 'submit' ? 'required|string|max:50' : 'nullable|string|max:50',
            'thoughts' => $action === 'submit' ? 'required|string|max:50' : 'nullable|string|max:50',
            'gratitude' => 'nullable|string|max:50',
            'activities' => 'nullable|string|max:50',
            'tags' => 'nullable|string|max:50',
        ];

        $validated = $request->validate($rules);

        $entry = DiaryEntry::where('user_id', auth()->id())
            ->where('status', 'draft')
            ->latest()
            ->first() ?? new DiaryEntry();

        $entry->mood = $validated['mood'] ?? null;
        $entry->emotions = $validated['emotions'] ?? null;
        $entry->thoughts = $validated['thoughts'] ?? null;
        $entry->gratitude = $validated['gratitude'] ?? null;
        $entry->activities = $validated['activities'] ?? null;
        $entry->tags = $validated['tags'] ?? null;
        $entry->status = $action === 'submit' ? 'submitted' : 'draft';
        $entry->user_id = auth()->id();

        $entry->save();

        return redirect()->route('diary', ['tab' => 'new'])
            ->with('success', $action === 'submit' ? 'Entry submitted!' : 'Draft saved!');
    }

}


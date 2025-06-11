@extends('layouts.vitality')

@section('title', 'New Entry')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-pink-600">New Diary Entry</h1>
            <a href="{{ route('diary.entries') }}"
               class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg self-start sm:self-auto flex items-center">
                ← Back to Past Reflections
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('diary.store') }}" class="space-y-6 bg-white p-6 rounded-xl shadow-md">
            @csrf

            <!-- Mood -->
            <div>
                <label class="block text-sm font-medium mb-2 text-pink-600">How are you feeling today?</label>
                <div class="flex gap-3 flex-wrap">
                    @foreach(['😢', '😕', '😐', '🙂', '😊'] as $emoji)
                        <label class="w-14 h-14 text-3xl rounded-full bg-pink-100 hover:bg-pink-200 transition flex items-center justify-center cursor-pointer">
                            <input type="radio" name="mood" value="{{ $emoji }}" class="hidden" required>
                            <span>{{ $emoji }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Emotions -->
            <div>
                <label class="block text-sm font-medium mb-2 text-pink-600">What emotions are present?</label>
                <textarea name="emotions" class="w-full p-3 border border-pink-300 rounded-md min-h-[100px]" placeholder="Joy, anxiety, contentment..." required></textarea>
            </div>

            <!-- Thoughts -->
            <div>
                <label class="block text-sm font-medium mb-2 text-pink-600">What's on your mind?</label>
                <textarea name="thoughts" class="w-full p-3 border border-pink-300 rounded-md min-h-[100px]" required></textarea>
            </div>

            <!-- Gratitude -->
            <div>
                <label class="block text-sm font-medium mb-2 text-pink-600">A moment of gratitude</label>
                <textarea name="gratitude" class="w-full p-3 border border-pink-300 rounded-md min-h-[100px]"></textarea>
            </div>

            <!-- Activities -->
            <div>
                <label class="block text-sm font-medium mb-2 text-pink-600">Activities (optional)</label>
                <textarea name="activities" class="w-full p-3 border border-pink-300 rounded-md min-h-[100px]"></textarea>
            </div>

            <!-- Tags -->
            <div>
                <label class="block text-sm font-medium mb-2 text-pink-600">Tags</label>
                <input type="text" name="tags" class="w-full p-3 border border-pink-300 rounded-md" placeholder="reflection, gratitude, work">
                <p class="text-xs text-pink-400 mt-1">Tags help you find entries later</p>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">
                <button type="submit" name="action" value="draft" class="px-4 py-2 border border-pink-600 rounded-md text-pink-600 hover:bg-pink-50">Save for Later</button>
                <button type="submit" name="action" value="submit" class="px-4 py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700">Save Entry</button>
            </div>
        </form>
    </div>
@endsection


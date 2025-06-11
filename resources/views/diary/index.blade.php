@extends('layouts.vitality')

@section('title', 'Diary')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-pink-600">My Feelings Journal</h1>
        </div>

        <!-- Tabs -->
        <div class="mb-6">
            <div class="grid grid-cols-2 gap-2 mb-6">
                <a href="?tab=new" class="{{ $activeTab === 'new' ? 'bg-pink-200 text-pink-800' : 'bg-pink-100 text-pink-600' }} px-4 py-2 rounded-lg text-center font-medium">New Entry</a>
                <a href="?tab=past" class="{{ $activeTab === 'past' ? 'bg-pink-200 text-pink-800' : 'bg-pink-100 text-pink-600' }} px-4 py-2 rounded-lg text-center font-medium">Past Reflections</a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- New Entry Tab -->
            @if($activeTab === 'new')
                <form method="POST" action="{{ route('diary.store') }}" class="space-y-6 bg-white p-6 rounded-xl shadow-md">
                    @csrf
                    <h2 class="text-xl font-semibold text-pink-700 mb-8">Today's Reflection</h2>

                    <div>
                        <label class="block text-sm font-medium mb-2 text-pink-600">How are you feeling today?</label>
                        <div class="flex justify-between gap-4">
                            @foreach(['😢', '😕', '😐', '🙂', '😊'] as $index => $emoji)
                                <div>
                                    <input
                                        type="radio"
                                        name="mood"
                                        id="mood-{{ $index }}"
                                        value="{{ $emoji }}"
                                        class="hidden peer"
                                        {{ old('mood', $draft->mood ?? '') === $emoji ? 'checked' : '' }}
                                    >
                                    <label
                                        for="mood-{{ $index }}"
                                        class="w-14 h-14 flex items-center justify-center text-4xl rounded-full
                           cursor-pointer transition-all duration-150 ease-in-out
                           bg-pink-100 hover:bg-pink-200
                           peer-checked:bg-pink-300
                           peer-checked:ring-2
                           peer-checked:ring-pink-500
                           peer-checked:font-bold
                           peer-checked:scale-105">
                                        {{ $emoji }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        @error('mood')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Emotions -->
                    <div>
                        <label class="block text-sm font-medium mb-2 text-pink-600">What emotions are present?</label>
                        <textarea name="emotions" class="w-full p-3 border border-pink-300 rounded-md min-h-[100px]" placeholder="Joy, anxiety, contentment...">{{ old('emotions', $draft->emotions ?? '') }}</textarea>
                        @error('emotions')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Thoughts -->
                    <div>
                        <label class="block text-sm font-medium mb-2 text-pink-600">What's on your mind?</label>
                        <textarea name="thoughts" class="w-full p-3 border border-pink-300 rounded-md min-h-[100px]">{{ old('thoughts', $draft->thoughts ?? '') }}</textarea>
                        @error('thoughts')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gratitude -->
                    <div>
                        <label class="block text-sm font-medium mb-2 text-pink-600">A moment of gratitude</label>
                        <textarea name="gratitude" class="w-full p-3 border border-pink-300 rounded-md min-h-[100px]">{{ old('gratitude', $draft->gratitude ?? '') }}</textarea>
                    </div>

                    <!-- Activities -->
                    <div>
                        <label class="block text-sm font-medium mb-2 text-pink-600">Activities (optional)</label>
                        <textarea name="activities" class="w-full p-3 border border-pink-300 rounded-md min-h-[100px]">{{ old('activities', $draft->activities ?? '') }}</textarea>
                    </div>

                    <!-- Tags -->
                    <div>
                        <label class="block text-sm font-medium mb-2 text-pink-600">Tags</label>
                        <input type="text" name="tags" class="w-full p-3 border border-pink-300 rounded-md" placeholder="reflection, gratitude, work" value="{{ old('tags', $draft->tags ?? '') }}">
                        <p class="text-xs text-pink-400 mt-1">Tags help you find entries later</p>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">
                        <button type="submit" name="action" value="draft" class="px-4 py-2 border border-pink-600 rounded-md text-pink-600 hover:bg-pink-50">Save for Later</button>
                        <button type="submit" name="action" value="submit" class="px-4 py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700">Save Entry</button>
                    </div>
                </form>
            @endif

            <!-- Past Reflections Tab -->
            @if($activeTab === 'past')
                <div class="grid grid-cols-1 gap-6">
                    @forelse($pastEntries as $entry)
                        <div class="bg-white rounded-xl shadow-md p-6">
                            <div class="flex items-center mb-2">
                                <div class="text-4xl mr-4">{{ $entry->mood }}</div>
                                <h3 class="font-semibold text-lg">{{ \Illuminate\Support\Str::limit($entry->thoughts, 60) }}</h3>
                            </div>
                            <p class="text-sm text-gray-600 mb-2"><strong>Emotions:</strong> {{ $entry->emotions }}</p>
                            <p class="text-sm text-gray-600 mb-2"><strong>Gratitude:</strong> {{ $entry->gratitude ?? '—' }}</p>
                            <p class="text-sm text-gray-600 mb-2"><strong>Activities:</strong> {{ $entry->activities ?? '—' }}</p>
                            <p class="text-xs text-gray-400">Tags: {{ $entry->tags }}</p>
                            <p class="text-xs text-gray-400 mt-2">Created at {{ $entry->created_at->format('M j, Y') }}</p>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">No past reflections yet.</p>
                    @endforelse
                </div>
            @endif
        </div>
    </div>
@endsection

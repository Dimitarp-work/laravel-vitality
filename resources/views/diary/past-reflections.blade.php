@extends('layouts.vitality')

@section('title', 'Past Reflections')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-pink-600">Past Reflections</h1>
            <a href="{{ route('diary.new') }}"
               class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg self-start sm:self-auto flex items-center">
                + New Entry
            </a>
        </div>

        {{-- Tabs --}}
        <div class="mb-6">
            <div class="grid grid-cols-2 gap-2 mb-6">
                <a href="?tab=all" class="{{ $activeTab === 'all' ? 'bg-pink-200 text-pink-800' : 'bg-pink-100 text-pink-600' }} px-4 py-2 rounded-lg text-center font-medium">All Entries</a>
                <a href="?tab=favorites" class="{{ $activeTab === 'favorites' ? 'bg-pink-200 text-pink-800' : 'bg-pink-100 text-pink-600' }} px-4 py-2 rounded-lg text-center font-medium">Favorites</a>
            </div>

            @if($activeTab === 'all')
                <div class="space-y-4">
                    @foreach($entries as $entry)
                        <div class="bg-white rounded-xl shadow-md p-6">
                            <div class="flex items-start gap-4">
                                <div class="text-4xl">{{ $entry->mood }}</div>
                                <div class="flex-grow">
                                    <div class="flex justify-between items-center mb-2">
                                        <h3 class="font-semibold text-lg truncate max-w-[70%]" title="{{ $entry->title ?? 'Diary Entry' }}">
                                            {{ \Illuminate\Support\Str::limit($entry->title ?? 'Diary Entry', 60) }}
                                        </h3>
                                        <span class="text-sm text-pink-500">{{ $entry->created_at->format('M j, Y') }}</span>
                                    </div>
                                    <p class="text-gray-700 mb-3">{{ \Illuminate\Support\Str::limit($entry->thoughts, 120) }}</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(explode(',', $entry->tags) as $tag)
                                            <span class="px-2 py-1 text-xs bg-pink-100 text-pink-600 rounded-full">#{{ trim($tag) }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if(count($entries) === 0)
                        <p class="text-center text-gray-500">No diary entries yet. Add a new one!</p>
                    @endif
                </div>
            @endif

            @if($activeTab === 'favorites')
                <div class="space-y-4">
                    @foreach($favoriteEntries as $entry)
                        <div class="bg-pink-50 rounded-xl shadow-md p-6 border border-pink-200">
                            <div class="flex items-start gap-4">
                                <div class="text-4xl">{{ $entry->mood }}</div>
                                <div class="flex-grow">
                                    <div class="flex justify-between items-center mb-2">
                                        <h3 class="font-semibold text-lg truncate max-w-[70%]" title="{{ $entry->title ?? 'Diary Entry' }}">
                                            {{ \Illuminate\Support\Str::limit($entry->title ?? 'Diary Entry', 60) }}
                                        </h3>
                                        <span class="text-sm text-pink-500">{{ $entry->created_at->format('M j, Y') }}</span>
                                    </div>
                                    <p class="text-gray-700 mb-3">{{ \Illuminate\Support\Str::limit($entry->thoughts, 120) }}</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(explode(',', $entry->tags) as $tag)
                                            <span class="px-2 py-1 text-xs bg-pink-100 text-pink-600 rounded-full">#{{ trim($tag) }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if(count($favoriteEntries) === 0)
                        <p class="text-center text-gray-500">No favorite entries yet.</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection


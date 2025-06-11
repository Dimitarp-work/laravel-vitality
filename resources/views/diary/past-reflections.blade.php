@extends('layouts.vitality')

@section('title', 'Past Reflections')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-pink-600">Past Reflections</h1>
            <a href="{{ route('diary.new') }}"
               class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg">
                New Entry
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">{{ session('success') }}</div>
        @endif

        @if($entries->count())
            <div class="space-y-4">
                @foreach($entries as $entry)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow border border-gray-100">
                        <div class="p-4 md:p-6 flex items-start">
                            <!-- Mood -->
                            <div class="mr-4 text-3xl md:text-4xl">
                                {{ $entry->mood }}
                            </div>

                            <!-- Content -->
                            <div class="flex-grow">
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-2">
                                    <h3 class="font-semibold text-base md:text-lg">
                                        {{ \Illuminate\Support\Str::limit($entry->thoughts, 50) }}
                                    </h3>
                                    <span class="text-xs md:text-sm text-gray-400">
                                {{ $entry->created_at->format('M d, Y') }}
                            </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-3">
                                    {{ \Illuminate\Support\Str::limit($entry->thoughts, 100) }}
                                </p>

                                @if($entry->tags)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach(explode(',', $entry->tags) as $tag)
                                            <span
                                                class="px-2 py-1 bg-pink-100 text-pink-700 rounded-full text-xs">
                                        #{{ trim($tag) }}
                                    </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center">No reflections yet. Start by creating a new one.</p>
        @endif
    </div>
@endsection


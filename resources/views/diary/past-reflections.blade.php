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
                    <div class="bg-white shadow rounded-lg p-4 border border-gray-100">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">{{ $entry->created_at->format('M d, Y') }}</span>
                            <span class="text-sm text-pink-600 font-medium">{{ $entry->mood }}</span>
                        </div>
                        <p class="mt-2 text-gray-800">{{ \Illuminate\Support\Str::limit($entry->thoughts, 100) }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center">No reflections yet. Start by creating a new one.</p>
        @endif
    </div>
@endsection

@extends('layouts.vitality')

@section('title', 'Edit Challenge')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <h1 class="text-3xl font-bold text-pink-900">Edit Challenge</h1>

        {{-- form to update the challenge --}}
        <form action="{{ route('challenges.update', $challenge) }}" method="POST" class="bg-white rounded-xl shadow p-6 space-y-4">
            @csrf
            @method('PUT') {{-- spoofing the HTTP verb to PUT --}}

            {{-- show validation errors if there are any --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li> {{-- loop through each error --}}
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- title input --}}
            <div>
                <label class="block text-sm font-semibold text-pink-800 mb-1">Title</label>
                <input type="text" name="title" value="{{ old('title', $challenge->title) }}" required class="w-full px-4 py-2 border border-pink-200 rounded text-sm">
            </div>

            {{-- description textarea --}}
            <div>
                <label class="block text-sm font-semibold text-pink-800 mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full px-4 py-2 border border-pink-200 rounded text-sm">{{ old('description', $challenge->description) }}</textarea>
            </div>

            {{-- category input --}}
            <div>
                <label class="block text-sm font-semibold text-pink-800 mb-1">Category</label>
                <input type="text" name="category" value="{{ old('category', $challenge->category) }}" class="w-full px-4 py-2 border border-pink-200 rounded text-sm">
            </div>

            {{-- difficulty dropdown + duration input --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- difficulty select --}}
                <div>
                    <label class="block text-sm font-semibold text-pink-800 mb-1">Difficulty</label>
                    <select name="difficulty" class="w-full px-4 py-2 border border-pink-200 rounded text-sm">
                        <option value="Beginner" {{ old('difficulty', $challenge->difficulty) === 'Beginner' ? 'selected' : '' }}>Beginner</option>
                        <option value="Intermediate" {{ old('difficulty', $challenge->difficulty) === 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                        <option value="Advanced" {{ old('difficulty', $challenge->difficulty) === 'Advanced' ? 'selected' : '' }}>Advanced</option>
                    </select>
                </div>

                {{-- duration input --}}
                <div>
                    <label class="block text-sm font-semibold text-pink-800 mb-1">Duration (days)</label>
                    <input type="number" name="duration_days" value="{{ old('duration_days', $challenge->duration_days) }}" min="1" class="w-full px-4 py-2 border border-pink-200 rounded text-sm">
                </div>
            </div>

            {{-- XP reward input --}}
            <div>
                <label class="block text-sm font-semibold text-pink-800 mb-1">XP Reward</label>
                <input type="number" name="xp_reward" value="{{ old('xp_reward', $challenge->xp_reward) }}" min="0" class="w-full px-4 py-2 border border-pink-200 rounded text-sm">
            </div>

            {{-- badge id input --}}
            <div>
                <label class="block text-sm font-semibold text-pink-800 mb-1">Badge ID</label>
                <input type="text" name="badge_id" value="{{ old('badge_id', $challenge->badge_id) }}" class="w-full px-4 py-2 border border-pink-200 rounded text-sm">
            </div>

            {{-- start date input --}}
            <div>
                <label class="block text-sm font-semibold text-pink-800 mb-1">Start Date</label>
                <input type="date"
                       name="start_date"
                       value="{{ old('start_date', $challenge->start_date->format('Y-m-d')) }}"
                       required
                       class="w-full px-4 py-2 border border-pink-200 rounded text-sm">
            </div>

            {{-- submit and cancel buttons --}}
            <div class="flex justify-between items-center">
                <a href="{{ route('challenges.index') }}" class="text-sm text-pink-600 hover:underline">Cancel</a>
                <button type="submit" class="bg-pink-400 hover:bg-pink-500 text-white px-5 py-2 rounded text-sm font-semibold">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
@endsection

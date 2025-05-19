@extends('layouts.vitality')

@section('title', 'Create Challenge')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <h1 class="text-3xl font-bold text-pink-900">Create a New Challenge</h1>
        <form action="{{ route('challenges.store') }}" method="POST" class="bg-white rounded-xl shadow p-6 space-y-4" novalidate>
            @csrf
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Title --}}
            <div>
                <label class="block text-sm font-semibold text-pink-800 mb-1">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required maxlength="255" placeholder="e.g. 14-Day Hydration Boost" class="w-full px-4 py-2 border border-pink-200 rounded text-sm focus:outline-none focus:ring-2 focus:ring-pink-300">
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-semibold text-pink-800 mb-1">Description</label>
                <textarea name="description" rows="3" maxlength="1000" placeholder="Briefly describe the challenge..." class="w-full px-4 py-2 border border-pink-200 rounded text-sm focus:outline-none focus:ring-2 focus:ring-pink-300">{{ old('description') }}</textarea>
            </div>

            {{-- Category --}}
            <div>
                <label class="block text-sm font-semibold text-pink-800 mb-1">Category</label>
                <input type="text" name="category" value="{{ old('category') }}" maxlength="255" placeholder="e.g. Mindfulness, Movement, Hydration" class="w-full px-4 py-2 border border-pink-200 rounded text-sm">
            </div>

            {{-- Difficulty + Duration --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-pink-800 mb-1">Difficulty <span class="text-red-500">*</span></label>
                    <select name="difficulty" required class="w-full px-4 py-2 border border-pink-200 rounded text-sm">
                        <option value="" disabled {{ old('difficulty') ? '' : 'selected' }}>Select difficulty</option>
                        <option value="Beginner" {{ old('difficulty') == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                        <option value="Intermediate" {{ old('difficulty') == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                        <option value="Advanced" {{ old('difficulty') == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-pink-800 mb-1">Duration <span class="text-red-500">*</span></label>
                    <input type="text" name="duration" value="{{ old('duration') }}" required pattern=".*\d+.*" maxlength="255" placeholder="e.g. 10 days, 2 weeks" class="w-full px-4 py-2 border border-pink-200 rounded text-sm" title="Please include at least one number">
                </div>
            </div>

            {{-- XP Reward --}}
            <div>
                <label class="block text-sm font-semibold text-pink-800 mb-1">XP Reward <span class="text-red-500">*</span></label>
                <input type="number" name="xp_reward" value="{{ old('xp_reward') }}" required min="0" placeholder="e.g. 150" class="w-full px-4 py-2 border border-pink-200 rounded text-sm">
            </div>

            {{-- Badge ID --}}
            <div>
                <label class="block text-sm font-semibold text-pink-800 mb-1">Badge ID</label>
                <input type="text" name="badge_id" value="{{ old('badge_id') }}" maxlength="255" placeholder="e.g. hydration-hero" class="w-full px-4 py-2 border border-pink-200 rounded text-sm">
            </div>

            {{-- Placeholder for friends --}}
            <div>
                <label class="block text-sm font-semibold text-pink-800 mb-1">Select Friends to Join</label>
                <div class="w-full px-4 py-2 border border-dashed border-pink-300 text-pink-400 text-sm rounded text-center">
                    [Select friends → will implement later]
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex justify-end">
                <button type="submit" class="bg-pink-400 hover:bg-pink-500 text-white px-5 py-2 rounded text-sm font-semibold">
                    Create Challenge
                </button>
            </div>
        </form>
    </div>
@endsection

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

            {{-- Category dropdown --}}
            <div>
                <label class="block text-sm font-semibold text-pink-800 mb-1">Category</label>
                <select name="category" class="w-full px-4 py-2 border border-pink-200 rounded text-sm" required>
                    <option value="">-- Select a Category --</option>
                    @php
                        $categories = ['Mindfulness', 'Movement', 'Nutrition', 'Sleep', 'Teamwork', 'Self-Care'];
                    @endphp
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
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
                    <label class="block text-sm font-semibold text-pink-800 mb-1">Duration in days <span class="text-red-500">*</span></label>
                    <input type="number" name="duration_days" value="{{ old('duration_days') }}" required min="0" placeholder="e.g. 7" class="w-full px-4 py-2 border border-pink-200 rounded text-sm">
                </div>
            </div>

            {{-- XP Reward --}}
            <div>
                <label class="block text-sm font-semibold text-pink-800 mb-1">XP Reward <span class="text-red-500">*</span></label>
                <input type="number" name="xp_reward" value="{{ old('xp_reward') }}" required min="0" placeholder="e.g. 150" class="w-full px-4 py-2 border border-pink-200 rounded text-sm">
            </div>

            {{-- Badge Selection --}}
            <div>
                <label class="block text-sm font-semibold text-pink-800 mb-1">Select Badge</label>
                <select name="badge_id" class="w-full px-4 py-2 border border-pink-200 rounded text-sm">
                    <option value="">-- Choose a Badge --</option>
                    @foreach ($badges as $badge)
                        <option value="{{ $badge->id }}" {{ old('badge_id') == $badge->id ? 'selected' : '' }}>
                            {{ $badge->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Start Date --}}
            <div>
                <label class="block text-sm font-semibold text-pink-800 mb-1">Start Date <span class="text-red-500">*</span></label>
                <input type="date"
                       name="start_date"
                       value="{{ old('start_date', now()->addDay()->format('Y-m-d')) }}"
                       required
                       class="w-full px-4 py-2 border border-pink-200 rounded text-sm">
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

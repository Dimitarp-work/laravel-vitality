@extends('layouts.vitality')

@section('title', 'Edit Goal')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-pink-600">Edit Goal</h1>
            <p class="text-gray-600">Update your wellness goal details</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Edit Goal Form -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6">
                <form action="{{ route('goals.update', $goal->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Goal Title *</label>
                        <input type="text" name="title" required value="{{ old('title', $goal->title) }}"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 @error('title') border-red-500 @enderror">
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="3"
                                  class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 @error('description') border-red-500 @enderror">{{ old('description', $goal->description) }}</textarea>
                        @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Icon *</label>
                            <input type="text" name="emoji" maxlength="2" placeholder="🏋️" value="{{ old('emoji', $goal->emoji) }}"
                                   class="w-full px-4 py-2 border rounded-lg text-2xl h-[42px] text-center focus:ring-2 focus:ring-pink-500 @error('emoji') border-red-500 @enderror">
                            @error('emoji') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Duration Fields -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Duration Value *</label>
                            <input type="number" name="duration_value" min="1" value="{{ old('duration_value', $goal->duration_value) }}"
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500 @error('duration_value') border-red-500 @enderror">
                            @error('duration_value') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Duration Unit *</label>
                            <select name="duration_unit"
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500 @error('duration_unit') border-red-500 @enderror">
                                <option value="minutes" {{ old('duration_unit') === 'minutes' ? 'selected' : '' }}>Minutes</option>
                                <option value="days" {{ old('duration_unit', $goal->duration_unit) === 'days' ? 'selected' : '' }}>Days</option>
                                <option value="hours" {{ old('duration_unit', $goal->duration_unit) === 'hours' ? 'selected' : '' }}>Hours</option>
                            </select>
                            @error('duration_unit') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('goals') }}"
                           class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">Cancel</a>
                        <button type="submit"
                                class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg flex items-center">
                            Update Goal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.vitality')

@php
use App\Constants\CheckInConstants;
@endphp

@section('title', 'Daily Check-ins')

@section('content')
<div class="w-full pl-0 md:pl-72">
    <div class="max-w-5xl mx-auto flex flex-col gap-8 px-6 py-8">
        <!-- Header Card -->
        <div class="w-full bg-gradient-to-r from-pink-200 to-pink-100 rounded-2xl shadow p-6">
            <h1 class="text-2xl font-bold text-pink-900 mb-4 flex items-center gap-2">
                <span class="material-icons text-pink-400">check_circle</span>
                Daily Check-ins
            </h1>
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="text-pink-700 font-medium">
                    {{ now()->format('l, F j, Y') }}
                </div>
                <div class="flex items-center gap-3 bg-white/50 px-5 py-2.5 rounded-xl">
                    <span class="text-pink-700 font-medium">Daily Progress</span>
                    <div class="w-36 h-2 bg-pink-100 rounded-full overflow-hidden">
                        @php
                            $completedCount = $checkins->where('isComplete', true)->count();
                            $totalCount = $checkins->count();
                            $percentage = $totalCount > 0 ? ($completedCount / $totalCount) * 100 : 0;
                        @endphp
                        <div id="progress-bar"
                             class="h-full bg-gradient-to-r from-pink-500 to-pink-400 rounded-full transition-all duration-300"
                             style="width: {{ $percentage }}%"
                             data-initial-percentage="{{ $percentage }}"
                        ></div>
                    </div>
                    <span id="progress-text"
                          class="text-pink-900 font-medium"
                          data-completed="{{ $completedCount }}"
                          data-total="{{ $totalCount }}"
                    >{{ $completedCount }}/{{ $totalCount }}</span>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="bg-pink-50 rounded-2xl shadow p-1.5 max-w-2xl mx-auto w-full">
            <div class="flex space-x-2">
                <a href="{{ route('checkins.index') }}" class="flex-1 px-4 py-3 text-pink-900 font-medium rounded-lg bg-white shadow-sm text-center">
                    Today
                </a>
                <a href="{{ route('checkins.week') }}" class="flex-1 px-4 py-3 text-pink-700 hover:bg-white/50 font-medium rounded-lg transition-all text-center">
                    This Week
                </a>
                <a href="{{ route('checkins.reminders') }}" class="flex-1 px-4 py-3 text-pink-700 hover:bg-white/50 font-medium rounded-lg transition-all text-center">
                    My Reminders
                </a>
            </div>
        </div>

        <!-- Check-ins Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Self-care Moments -->
            <div class="bg-white rounded-2xl shadow p-6">
                <div class="font-bold text-pink-900 mb-4 text-lg flex items-center gap-2">
                    <span class="material-icons text-pink-400">favorite</span>
                    Self-care Moments
                    <span class="ml-2 text-xs bg-pink-100 text-pink-700 rounded-full px-3 py-0.5">5 tasks</span>
                </div>
                <div class="space-y-4">
                    @foreach($checkins as $checkin)
                        <div class="group grid grid-cols-[1fr,120px] gap-4 p-4 bg-pink-50 rounded-xl hover:bg-pink-100/50 transition-all">
                            <div class="min-w-0">
                                <span class="text-pink-900 break-all">{{$checkin->title}}</span>
                            </div>
                            <div class="flex justify-end">
                                                        <button
                                type="button"
                                data-id="{{ $checkin->id }}"
                                data-completed="{{ $checkin->isComplete }}"
                                    class="complete-btn whitespace-nowrap text-white font-semibold px-4 py-2 rounded transition {{ $checkin->isComplete ? 'bg-green-500 hover:bg-green-600' : 'bg-pink-500 hover:bg-pink-600' }}"
                                {{ $checkin->isComplete ? 'disabled' : '' }}
                            >
                                {{ $checkin->isComplete ? 'Completed' : 'Not Done' }}
                            </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        <!-- Add Custom Check-in -->
        <div class="bg-pink-50 rounded-2xl shadow p-6">
            <div class="font-bold text-pink-900 mb-4 text-lg flex items-center gap-2">
                <span class="material-icons text-pink-400">add_circle</span>
                Create Custom Check-in
            </div>
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative flex items-center gap-2">
                    <span class="material-icons text-green-500">check_circle</span>
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->has('title'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative flex items-center gap-2">
                    <span class="material-icons text-red-500">error_outline</span>
                    {{ $errors->first('title') }}:
                </div>
            @endif
            <form id="custom-checkin-form" class="flex flex-col gap-2" method="POST" action="{{ route('checkins.store') }}">
                @csrf
                <div class="flex gap-3">
                    <input type="text"
                        id="custom-checkin-title"
                        name="title"
                        placeholder="Write a short title..."
                        class="flex-1 px-4 py-2.5 rounded-lg border border-pink-200 focus:ring-2 focus:ring-pink-300 text-sm @error('title') border-red-500 focus:ring-red-500 @enderror"
                        required
                        value="{{ old('title') }}"
                    >
                    <button type="submit" class="bg-pink-400 hover:bg-pink-500 text-white rounded-lg px-5 py-1.5 font-semibold w-24 transition text-sm self-start">
                        Add
                    </button>
                </div>
                <label for="custom-checkin-title" class="text-xs text-gray-500">Max {{ CheckInConstants::TITLE_MAX_LENGTH }} characters</label>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        window.CheckInConstants = {
            TITLE_MAX_LENGTH: {{ CheckInConstants::TITLE_MAX_LENGTH }}
        };
    </script>
    @vite(['resources/js/checkins.js'])
@endpush

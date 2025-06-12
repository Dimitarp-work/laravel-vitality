@extends('layouts.vitality')

@section('title', 'Add New Reminder')

@section('content')
<div class="w-full pl-0 md:pl-72">
    <div class="max-w-5xl mx-auto flex flex-col gap-8 px-6 py-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('reminders.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-2">
                <span class="material-icons">arrow_back</span>
                <span class="font-medium">Back to Reminders</span>
            </a>
        </div>
        <h1 class="text-2xl font-bold text-pink-600 mb-6">Choose what you would like to be reminded about</h1>

        <form action="{{ route('reminders.store') }}" method="POST" class="bg-white rounded-2xl shadow p-6 space-y-6">
            @csrf

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <!-- Goals Section -->
            <div>
                <h2 class="text-xl font-bold text-pink-900 mb-4">Goals</h2>
                @if($goals->isEmpty())
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <p class="text-gray-600 mb-3">You don't have any Goals right now</p>
                        <a href="{{ route('goals') }}" class="w-full border-2 border-dashed border-gray-300 rounded-lg py-2.5 text-gray-500 font-medium flex items-center justify-center gap-2 hover:bg-gray-50 transition">
                            <span class="material-icons text-lg">add</span>
                            Add some
                        </a>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($goals as $goal)
                            <div class="flex items-center bg-gray-50 rounded-lg p-3">
                                <input type="checkbox" name="goals[]" value="{{ $goal->id }}" id="goal_{{ $goal->id }}" class="form-checkbox h-5 w-5 text-pink-600 rounded focus:ring-pink-500">
                                <label for="goal_{{ $goal->id }}" class="ml-3 text-gray-700">{{ $goal->title }}</label>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Challenges Section -->
            <div>
                <h2 class="text-xl font-bold text-pink-900 mb-4">Challenges</h2>
                @if($challenges->isEmpty())
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <p class="text-gray-600 mb-3">You have not joined any challenges</p>
                        <a href="{{ route('challenges.index') }}" class="w-full border-2 border-dashed border-gray-300 rounded-lg py-2.5 text-gray-500 font-medium flex items-center justify-center gap-2 hover:bg-gray-50 transition">
                            <span class="material-icons text-lg">emoji_events</span>
                            Join some
                        </a>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($challenges as $challenge)
                            <div class="flex items-center bg-gray-50 rounded-lg p-3">
                                <input type="checkbox" name="challenges[]" value="{{ $challenge->id }}" id="challenge_{{ $challenge->id }}" class="form-checkbox h-5 w-5 text-pink-600 rounded focus:ring-pink-500">
                                <label for="challenge_{{ $challenge->id }}" class="ml-3 text-gray-700">{{ $challenge->title }}</label>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Daily Check-ins Section -->
            <div>
                <h2 class="text-xl font-bold text-pink-900 mb-4">Daily Check-ins</h2>
                @if($dailyCheckIns->isEmpty())
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <p class="text-gray-600 mb-3">You don't have any Daily Check-ins currently</p>
                        <a href="{{ route('checkins.index') }}" class="w-full border-2 border-dashed border-gray-300 rounded-lg py-2.5 text-gray-500 font-medium flex items-center justify-center gap-2 hover:bg-gray-50 transition">
                            <span class="material-icons text-lg">add</span>
                            Add some
                        </a>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($dailyCheckIns as $checkin)
                            <div class="flex items-center bg-gray-50 rounded-lg p-3">
                                <input type="checkbox" name="daily_checkins[]" value="{{ $checkin->id }}" id="checkin_{{ $checkin->id }}" class="form-checkbox h-5 w-5 text-pink-600 rounded focus:ring-pink-500">
                                <label for="checkin_{{ $checkin->id }}" class="ml-3 text-gray-700">{{ $checkin->title }}</label>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white rounded-xl px-6 py-2.5 font-semibold transition flex items-center gap-2">
                    <span class="material-icons text-sm">save</span>
                    Create Reminders
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.vitality')

@section('title', 'Wellness Community')

@section('content')
    <div class="px-4 py-10">
        <h1 class="text-3xl font-bold text-pink-600">Wellness Community</h1>
        <p class="text-gray-500 mb-6">See how your wellness journey compares with others</p>

        <!-- Tabs -->
        <div class="flex space-x-4 mb-6">
            <a class="bg-pink-100 text-pink-700 font-semibold px-4 py-2 rounded-lg">✨ XP Leaders</a>
            <button class="text-gray-500 hover:text-pink-600 font-semibold px-4 py-2 rounded-lg">🏅 Badge Champions</button>
            <button class="text-gray-500 hover:text-pink-600 font-semibold px-4 py-2 rounded-lg">🏆 Streak Masters</button>
        </div>

        <!-- Filters -->
        <div class="flex space-x-3 mb-6">
            <button class="flex items-center gap-1 px-4 py-2 border rounded-md text-sm text-gray-600"><span class="material-icons text-base">filter_list</span>All Time</button>
            <button class="flex items-center gap-1 px-4 py-2 border rounded-md text-sm text-gray-600"><span class="material-icons text-base">groups</span>Everyone</button>
        </div>

        <!-- Leaderboard Panel -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-semibold mb-6">Experience Points Leaders</h2>

            <!-- Top 3 -->
            <div class="flex justify-center gap-12 mb-8">
                <!-- 2nd Place -->
                <div class="text-center">
                    <div class="w-16 h-16 rounded-full bg-gray-200 mx-auto text-xl font-bold text-gray-700 flex items-center justify-center border-4 border-gray-300">JD</div>
                    <div class="text-sm mt-2 font-medium text-gray-800">John Doe</div>
                    <div class="text-sm text-gray-500">450 XP</div>
                    <div class="text-xs text-pink-500 mt-1">Wellness Warrior</div>
                    <div class="text-gray-600 font-bold text-sm mt-1">2</div>
                </div>

                <!-- 1st Place -->
                <div class="text-center">
                    <div class="w-20 h-20 rounded-full bg-yellow-100 mx-auto text-xl font-bold text-yellow-700 flex items-center justify-center border-4 border-yellow-400 relative">
                        JS
                        <span class="absolute -top-5 left-1/2 transform -translate-x-1/2 text-yellow-500 text-xl">🏆</span>
                    </div>
                    <div class="text-base mt-2 font-semibold text-gray-900">Jane Smith</div>
                    <div class="text-sm text-gray-600">520 XP</div>
                    <div class="text-xs text-pink-500 mt-1">Mindfulness Maven</div>
                    <div class="text-yellow-600 font-bold text-sm mt-1">1</div>
                </div>

                <!-- 3rd Place -->
                <div class="text-center">
                    <div class="w-16 h-16 rounded-full bg-orange-100 mx-auto text-xl font-bold text-orange-700 flex items-center justify-center border-4 border-orange-400">AJ</div>
                    <div class="text-sm mt-2 font-medium text-gray-800">Alex Johnson</div>
                    <div class="text-sm text-gray-500">380 XP</div>
                    <div class="text-xs text-pink-500 mt-1">Streak Superstar</div>
                    <div class="text-orange-600 font-bold text-sm mt-1">3</div>
                </div>
            </div>

            <!-- Rest of the leaderboard -->
            <div class="space-y-3">
                @php
                    $users = [
                        ['rank' => 4, 'initials' => 'SW', 'name' => 'Sam Wilson', 'title' => 'Hydration Hero', 'xp' => 340],
                        ['rank' => 5, 'initials' => 'TB', 'name' => 'Taylor Brown', 'title' => 'Wellness Rookie', 'xp' => 290],
                        ['rank' => 6, 'initials' => 'JL', 'name' => 'Jordan Lee', 'title' => 'Meditation Master', 'xp' => 270],
                        ['rank' => 7, 'initials' => 'CM', 'name' => 'Casey Miller', 'title' => 'Wellness Explorer', 'xp' => 250],
                    ];
                @endphp

                @foreach ($users as $user)
                    <div class="flex justify-between items-center bg-gray-50 px-4 py-3 rounded-md">
                        <div class="flex items-center gap-4">
                            <span class="text-gray-700 font-bold w-5">{{ $user['rank'] }}</span>
                            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center font-bold text-gray-600">{{ $user['initials'] }}</div>
                            <div>
                                <div class="text-sm font-medium text-gray-800">{{ $user['name'] }}</div>
                                <div class="text-xs text-pink-500">{{ $user['title'] }}</div>
                            </div>
                        </div>
                        <div class="text-gray-700 font-medium">{{ $user['xp'] }} XP</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

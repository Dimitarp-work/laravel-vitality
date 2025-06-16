@extends('layouts.vitality')

@section('title', 'Wellness Community')

@section('content')
    <div class="w-full pl-0 md:pl-72">
        <div class="max-w-4xl mx-auto px-6 py-8">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
                <h1 class="text-2xl md:text-3xl font-bold text-pink-900 flex items-center gap-2">
                    <span class="material-icons text-pink-400">emoji_events</span>
                    Wellness Community
                </h1>
                <p class="text-gray-500">See how your wellness journey compares with others</p>
            </div>

            <!-- Tabs -->
            <div class="mb-6">
                <div class="bg-pink-50 rounded-2xl shadow p-1.5 max-w-2xl mx-auto w-full mb-6">
                    <div class="flex space-x-2">
                        <a href="{{ route('leaderboard.xp') }}"
                           class="flex-1 px-4 py-3 text-pink-700 font-medium rounded-lg hover:bg-white/50 text-center transition-all">
                            <span class="material-icons text-base mr-1">stars</span>
                            XP Leaders
                        </a>
                        <a href="{{ route('leaderboard.badges') }}"
                           class="flex-1 px-4 py-3 text-pink-900 font-medium rounded-lg bg-white shadow-sm text-center transition-all">
                            <span class="material-icons text-base mr-1">military_tech</span>
                            Badge Leaders
                        </a>
                    </div>
                </div>

                <!-- Leaderboard Panel -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-xl font-semibold mb-6 text-pink-900">Badge Leaders</h2>

                    <!-- Top 3 -->
                    <div class="flex justify-center gap-12 mb-8">
                        @foreach ($topThree as $index => $user)
                            @php
                                $rank = $index + 1;
                                $colors = [
                                    1 => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'border' => 'border-yellow-400', 'emoji' => '🏆'],
                                    2 => ['bg' => 'bg-gray-200', 'text' => 'text-gray-700', 'border' => 'border-gray-300', 'emoji' => ''],
                                    3 => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700', 'border' => 'border-orange-400', 'emoji' => ''],
                                ];
                                $color = $colors[$rank];
                                $initials = strtoupper(substr(explode(' ', $user['name'])[0] ?? '', 0, 1) . substr(explode(' ', $user['name'])[1] ?? '', 0, 1));
                                $title = $user['title'] ?? 'Top Performer';
                            @endphp

                    <div class="text-center">
                        <div class="{{ $rank === 1 ? 'w-20 h-20 text-xl' : 'w-16 h-16 text-lg' }} rounded-full {{ $color['bg'] }} mx-auto font-bold {{ $color['text'] }} flex items-center justify-center border-4 {{ $color['border'] }} relative">
                            {{ $initials }}
                            @if ($color['emoji'])
                                <span class="absolute -top-5 left-1/2 transform -translate-x-1/2 text-xl {{ $color['text'] }}">{{ $color['emoji'] }}</span>
                            @endif
                        </div>
                        <div class="text-sm mt-2 font-medium text-gray-800">{{ $user['name'] }}</div>
                        <div class="text-sm text-gray-500">{{ $user['badges_count'] }} Badges</div>
                        <div class="text-xs text-pink-500 mt-1">{{ $title }}</div>
                        <div class="font-bold text-sm mt-1 {{ $color['text'] }}">{{ $rank }}</div>
                        <div class="mt-1">
                            @if ($user['trend'] === 'up')
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                </svg>
                            @elseif ($user['trend'] === 'down')
                                <svg class="w-5 h-5 text-red-500 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-gray-400 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 12h16"/>
                                </svg>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Rest of the leaderboard -->
            <div class="space-y-3">
                @foreach ($users as $index => $user)
                    @php
                        $initials = strtoupper(substr(explode(' ', $user['name'])[0] ?? '', 0, 1) . substr(explode(' ', $user['name'])[1] ?? '', 0, 1));
                    @endphp
                    <div class="flex justify-between items-center bg-gray-50 px-4 py-3 rounded-md">
                        <div class="flex items-center gap-4">
                            <span class="text-gray-700 font-bold w-5">{{ $index + 4 }}</span>
                            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center font-bold text-gray-600">{{ $initials }}</div>
                            <div>
                                <div class="text-sm font-medium text-gray-800">{{ $user['name'] }}</div>
                                <div class="text-xs text-pink-500">{{ $user['title'] ?? 'Participant' }}</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 text-gray-700 font-medium">
                            {{ $user['badges_count'] }} Badges
                            @if ($user['trend'] === 'up')
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                </svg>
                            @elseif ($user['trend'] === 'down')
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 12h16"/>
                                </svg>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

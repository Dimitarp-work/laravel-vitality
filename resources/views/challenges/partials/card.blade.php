@php
    $difficultyColors = [
        'Beginner' => 'bg-green-100 text-green-600',
        'Intermediate' => 'bg-yellow-100 text-yellow-600',
        'Advanced' => 'bg-red-100 text-red-600',
    ];
@endphp

<div class="bg-white rounded-2xl shadow p-6 @if($challenge['status'] === 'completed') bg-green-50 @endif">
    @if($challenge['status'] === 'active' && isset($challenge['progress']))
        <div class="w-full h-2 bg-pink-100 rounded-full mb-4 overflow-hidden">
            <div class="h-full bg-pink-400" style="width: {{ $challenge['progress'] }}%"></div>
        </div>
    @endif

    <div class="flex justify-between items-start">
        <div>
            <h3 class="font-semibold text-lg text-pink-900 flex items-center gap-2">
                {{ $challenge['title'] }}
                <span class="text-xs px-2 py-0.5 rounded-full {{ $difficultyColors[$challenge['difficulty']] ?? 'bg-gray-100 text-gray-700' }}">
                    {{ $challenge['difficulty'] }}
                </span>
            </h3>
            <p class="text-sm text-pink-700 mt-1">{{ $challenge['description'] }}</p>
        </div>
        <div class="text-right text-xs text-pink-600 space-y-1 mt-1">
            <div class="flex items-center gap-1">
                <span class="material-icons text-pink-400 text-base">schedule</span> {{ $challenge['duration'] }}
            </div>
            <div class="flex items-center gap-1">
                <span class="material-icons text-pink-400 text-base">group</span> {{ $challenge['participants'] }} participants
            </div>
        </div>
    </div>

    @if($challenge['status'] === 'active' && isset($challenge['daysCompleted']))
        <div class="text-xs text-pink-700 mt-3 mb-1 flex justify-between">
            <span>Progress: {{ $challenge['daysCompleted'] }}/{{ $challenge['totalDays'] }} days</span>
            <span>{{ round(($challenge['daysCompleted'] / $challenge['totalDays']) * 100) }}%</span>
        </div>
    @endif

    <div class="flex justify-between items-center mt-4">
        <div class="text-sm flex items-center text-pink-700 gap-1">
            <span class="material-icons text-pink-400 text-base">emoji_events</span> +{{ $challenge['xpReward'] }} XP
        </div>

        @if($challenge['status'] === 'available')
            <button class="bg-pink-400 hover:bg-pink-500 text-white px-4 py-1.5 text-sm rounded">Join Challenge</button>
        @elseif($challenge['status'] === 'active')
            <button class="bg-pink-400 hover:bg-pink-500 text-white px-4 py-1.5 text-sm rounded">Log Progress</button>
        @elseif($challenge['status'] === 'completed')
            <span class="flex items-center text-green-600 text-sm font-medium gap-1">
                <span class="material-icons text-base">check_circle</span> Completed
            </span>
        @endif
    </div>
</div>

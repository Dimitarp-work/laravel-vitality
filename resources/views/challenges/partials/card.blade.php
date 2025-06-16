@php
    /** @var \App\Models\Challenge $challenge */
    // set background and text colors for each difficulty
    $difficultyColors = [
        'Beginner' => 'bg-green-100 text-green-600',
        'Intermediate' => 'bg-yellow-100 text-yellow-600',
        'Advanced' => 'bg-red-100 text-red-600',
    ];

    // check if user already joined this challenge

    $alreadyJoined = $challenge->participants->contains(auth()->id());

    // get pivot data for current user if joined
    $pivot = $alreadyJoined ? $challenge->participants->find(auth()->id())->pivot : null;

    // calculate progress if we have data
    $progressPercent = $pivot ? round(($pivot->days_completed / $challenge->duration_days) * 100) : null;
@endphp

    <!-- challenge card container -->
<div class="bg-white rounded-2xl shadow p-6 @if($challenge->status === 'completed') bg-green-50 @endif">

    <!-- progress bar or countdown -->
    @if($challenge->status === 'active' && $pivot)
        <!-- user is active in challenge, show real progress -->
        <div class="w-full h-2 bg-pink-100 rounded-full mb-4 overflow-hidden">
            <div class="h-full bg-pink-400" style="width: {{ $progressPercent }}%"></div>
        </div>
    @elseif($challenge->status === 'available' && now()->lt($challenge->start_date))
        <!-- challenge hasn't started yet, show countdown -->
        @php
            $daysUntilStart = now()->diffInDays($challenge->start_date);
        @endphp
        <div class="text-xs text-pink-700 mb-2">
            Starts in {{ $daysUntilStart }} day{{ $daysUntilStart !== 1 ? 's' : '' }}
        </div>
    @endif


    <!-- title, difficulty and description -->
    <div class="flex justify-between items-start">
        <div>
            <h3 class="font-semibold text-lg text-pink-900 flex items-center gap-2">
                {{ $challenge->title }}
                <!-- difficulty badge -->
                <span class="text-xs px-2 py-0.5 rounded-full {{ $difficultyColors[$challenge->difficulty] ?? 'bg-gray-100 text-gray-700' }}">
                    {{ $challenge->difficulty }}
                </span>
            </h3>
            <p class="text-sm text-pink-700 mt-1">{{ $challenge->description }}</p>
        </div>

        <!-- duration and participants -->
        <div class="text-right text-xs text-pink-600 space-y-1 mt-1">
            <div class="flex items-center gap-1">
                <span class="material-icons text-pink-400 text-base">schedule</span> {{ $challenge->duration_days }} days
            </div>
            <div class="flex items-center gap-1">
                <button onclick="openParticipantsOverlay({{ $challenge->id }})"
                        class="text-pink-600 hover:underline text-sm ml-2">
                    {{ $challenge->participants->count() }} participants
                </button>
            </div>
        </div>
    </div>

    <!-- text progress info (days completed / % shown only if joined) -->
    @if($challenge->status === 'active' && $pivot)
        <div class="text-xs text-pink-700 mt-3 mb-1 flex justify-between">
            <span>Progress: {{ $pivot->days_completed }}/{{ $challenge->duration_days }} days</span>
            <span>{{ $progressPercent }}%</span>
        </div>
    @endif

    <!-- bottom row with xp and buttons -->
    <div class="flex justify-between items-center mt-4">
        <div class="text-sm flex items-center text-pink-700 gap-1">
            <span class="material-icons text-pink-400 text-base">emoji_events</span> +{{ $challenge->xp_reward }} XP
        </div>

        <!-- show correct button or label depending on status and user -->
        @if($challenge->status === 'available' && now()->lt($challenge->start_date) && !$alreadyJoined)
            <form method="POST" action="{{ route('challenges.join', $challenge->id) }}">
                @csrf
                <button class="bg-pink-400 hover:bg-pink-500 text-white px-4 py-1.5 text-sm rounded">
                    Join Challenge
                </button>
            </form>
        @elseif($challenge->status === 'active' && $pivot)
            <form method="POST" action="{{ route('challenges.log', $challenge->id) }}">
                @csrf
                <button class="bg-pink-400 hover:bg-pink-500 text-white px-4 py-1.5 text-sm rounded">
                    Log Progress
                </button>
            </form>
        @elseif($challenge->status === 'completed')
            <span class="flex items-center text-green-600 text-sm font-medium gap-1">
                <span class="material-icons text-base">check_circle</span> Completed
            </span>
        @endif
    </div>
</div>

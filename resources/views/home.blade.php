@extends('layouts.vitality')

@section('title', 'Home')

@section('content')
<div class="w-full pl-0 md:pl-72">
    <div class="max-w-6xl mx-auto px-6 py-8">
        @php
            $user = Auth::user();
            $xp = $user->xp ?? 0;
            $credits = $user->credits ?? 0;
            $xpToNextLevel = 500;
            $level = floor($xp / $xpToNextLevel) + 1;
            $xpProgress = $xp % $xpToNextLevel;
            $progressPercent = min(100, ($xpProgress / $xpToNextLevel) * 100);
        @endphp

      @php
    $bannerUrl = $user->banner?->image_url;
    $style = $bannerUrl
        ? "background-image: linear-gradient(to right, rgba(255,255,255,0.6), rgba(255,255,255,0.1)), url('" . e($bannerUrl) . "');"
        : "background-image: linear-gradient(to right, #fbcfe8, #fce7f3);";
@endphp

<div class="w-full rounded-2xl shadow p-6 flex flex-col md:flex-row items-center gap-6 mb-6"
     style="{{ $style }} background-size: cover; background-position: center;">

    <div class="flex items-center gap-4 flex-1">
        <div class="w-16 h-16 rounded-full bg-pink-300 flex items-center justify-center text-3xl font-bold text-white">
            {{ strtoupper(substr(explode(' ', $user->name)[0] ?? '', 0, 1) . substr(explode(' ', $user->name)[1] ?? '', 0, 1)) }}
        </div>
        <div>
            <div class="font-semibold text-xl text-pink-900">
                <div class="flex items-center gap-2">
                    <span>Welcome, {{ $user->name }}</span>
                    @if($user->activeBadge && $user->activeBadge->image_url)
                        <img src="{{ asset($user->activeBadge->image_url) }}"
                             alt="{{ $user->activeBadge->name }}"
                             title="{{ $user->activeBadge->name }}"
                             class="w-6 h-6 rounded-full object-contain ring ring-pink-300" />
                    @endif
                </div>
                <span class="text-sm text-pink-700">{{ $user->activeBadge->name ?? 'No Badge' }}</span>
            </div>
        </div>
    </div>
</div>

            <!-- Main grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="flex flex-col gap-8">
                    <!-- Mood widget -->
                    <div id="mood-widget" class="bg-white rounded-2xl shadow p-0 flex flex-col items-center min-h-[220px] w-full">
                        <div class="font-bold text-pink-900 mt-8 mb-4 text-lg flex items-center gap-2">
                            <span class="material-icons text-pink-400">mood</span>
                            How are you feeling today?
                        </div>
                        <form id="mood-form" class="flex flex-col items-center w-full">
                            <div class="flex gap-6 sm:gap-8 text-3xl mb-2 justify-center">
                               @foreach(['sad'=>'😢','stressed'=>'😣','neutral'=>'😐','calm'=>'😌','happy'=>'😊'] as $value => $emoji)
    <div class="flex flex-col items-center">
        <label>
            <input type="radio" name="mood" value="{{ $value }}" class="sr-only" />
            <span class="cursor-pointer transition hover:scale-125 w-12 h-12 flex items-center justify-center rounded-full" title="{{ ucfirst($value) }}">{{ $emoji }}</span>
        </label>
        <span data-mood="{{ $value }}" class="mt-1 text-xs text-gray-500">{{ ucfirst($value) }}</span>
    </div>
                                @endforeach
                            </div>
                        </form>
                        <div class="w-full flex justify-center mt-6 mb-8 px-4">
                            <img id="mood-loading-gif" src="/images/capybara-rub.gif" alt="Loading..." class="h-32 w-32 hidden z-20" />
                            <div id="mood-message-container" class="relative bg-pink-50 border border-pink-100 rounded-2xl shadow-sm max-w-lg w-full px-8 py-7 flex flex-col items-center">
                                <div id="mood-message-content" class="flex items-start gap-3 w-full">
                                    <span id="mood-message-icon" class="material-icons text-pink-400 text-2xl mt-0.5">auto_awesome</span>
                                    <span id="mood-message" class="flex-1 text-pink-700 text-base font-normal leading-relaxed text-center"></span>
                                </div>
                                <div id="capychat-btn-container" class="w-full flex justify-center mt-4 hidden">
                                    <a href="{{ route('capychat') }}" class="bg-pink-400 hover:bg-pink-500 text-white rounded-lg px-6 py-2 font-semibold transition text-base shadow">
                                        Open Capy Chat
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

<!-- Wellness Inspiration -->
<div class="bg-pink-50 rounded-2xl shadow p-6 flex flex-col">
    <div class="font-bold text-pink-900 mb-3 flex items-center gap-2">
        <span class="material-icons text-pink-400">lightbulb</span>
        Wellness Inspiration
    </div>
    <div class="space-y-2">
        @if(isset($newestArticle) && $newestArticle)
            <a href="{{ route('articles.show', $newestArticle) }}" class="block bg-white rounded-lg p-3 flex flex-col shadow-sm hover:bg-gray-50 transition">
                <span class="font-semibold text-pink-900">{{ $newestArticle->title }}</span>
                <span class="text-xs text-pink-600">Newest & Most Popular</span>
            </a>
        @endif
        @if(isset($mostPopularArticle) && $mostPopularArticle)
            <a href="{{ route('articles.show', $mostPopularArticle) }}" class="block bg-white rounded-lg p-3 flex flex-col shadow-sm hover:bg-gray-50 transition">
                <span class="font-semibold text-pink-900">{{ $mostPopularArticle->title }}</span>
                <span class="text-xs text-pink-600">All-Time Most Popular</span>
            </a>
        @endif
        @if((!isset($newestArticle) || !$newestArticle) && (!isset($mostPopularArticle) || !$mostPopularArticle))
            <p class="text-pink-700 text-sm">No articles found yet. Check back soon!</p>
        @endif
    </div>
    <a href="{{ route('articles.index') }}"
       class="bg-pink-100 text-pink-700 rounded-lg px-4 py-1 mt-4 font-semibold w-fit hover:bg-pink-200 transition text-sm self-start"
       aria-label="Explore articles">Explore Articles</a>
</div>


                    <!-- Customization Store -->
                    <div class="bg-white rounded-2xl shadow p-6 flex flex-col">
                        <div class="font-bold text-pink-900 mb-2 flex items-center gap-2">
                            <span class="material-icons text-pink-400">store</span>
                            Customization Store
                        </div>
                        <span class="text-pink-700 font-extrabold text-lg">{{ $credits }} Credits</span>
                        <span class="text-xs text-pink-700 mb-2">Use your credits to customize your profile</span>
                        <a href="{{ route('shop.index') }}" class="bg-pink-100 text-pink-700 rounded-lg px-4 py-1 mt-2 font-semibold w-fit hover:bg-pink-200 transition text-sm self-start">
                            Visit Store
                        </a>
                    </div>

                    <!-- Challenges Widget -->
                    @php
                        $joinedChallenges = Auth::user()->joinedChallenges()->with('participants')->orderBy('start_date')->take(3)->get();
                    @endphp
                    <div class="bg-pink-50 rounded-2xl shadow p-6 flex flex-col mb-2">
                        <div class="font-bold text-pink-900 mb-2 flex items-center gap-2">
                            <span class="material-icons text-pink-400">emoji_events</span>
                            Your Challenges
                        </div>
                        <div class="flex flex-col gap-2 mb-2">
                            @forelse($joinedChallenges as $challenge)
                                <div class="bg-white rounded-lg p-3 flex flex-col shadow-sm">
                                    <div class="flex items-center justify-between">
                                        <div class="font-semibold text-pink-900">{{ $challenge->title }}</div>
                                        <span class="text-xs px-2 py-0.5 rounded-full bg-pink-100 text-pink-700 font-semibold ml-2">{{ $challenge->difficulty }}</span>
                                    </div>
                                    <div class="text-xs text-pink-600 mt-1">{{ \Illuminate\Support\Str::limit($challenge->description, 50) }}</div>
                                    <div class="flex items-center gap-2 mt-2">
                                        <span class="material-icons text-pink-400 text-base">schedule</span>
                                        <span class="text-xs text-pink-700">{{ $challenge->duration_days }} days</span>
                                        <span class="material-icons text-pink-400 text-base ml-3">group</span>
                                        <span class="text-xs text-pink-700">{{ $challenge->participants->count() }} joined</span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-pink-700 text-sm">You haven't joined any challenges yet.</div>
                            @endforelse
                        </div>
                        <a href="{{ route('challenges.index') }}" class="text-pink-500 text-xs font-semibold ml-auto hover:underline">View All Challenges</a>
                    </div>
                </div>

                <div class="flex flex-col gap-8">
                    <!-- Capture Thought -->
                    <form method="POST" action="{{ route('thought.store') }}">
                        @csrf
                        <div class="bg-white rounded-2xl shadow p-6 flex flex-col">
                            <div class="font-bold text-pink-900 mb-2 text-lg flex items-center gap-2">
                                <span class="material-icons text-pink-400">edit</span>
                                A thought to capture?
                            </div>
                            <textarea name="thought" required maxlength="60" class="border border-pink-200 rounded-lg p-2 mb-3 resize-none focus:ring-2 focus:ring-pink-300 text-sm" rows="2" placeholder="A quick note that comes to mind..." id="thought-textarea"></textarea>
                            <div class="text-xs text-pink-500 mb-2" id="thought-char-count">0 / 60</div>
                            @php
                                $lastThought = Auth::user()->diaryEntries()->where('thoughts', '!=', '')->latest()->first();
                            @endphp
                            @if(session('last_thought') || $lastThought)
                                <div class="mb-3 p-3 bg-pink-50 rounded-lg text-sm text-pink-700 border border-pink-200">
                                    <div class="font-medium text-pink-900 mb-1">Last thought captured:</div>
                                    {{ session('last_thought') ?? $lastThought->thoughts }}
                                </div>
                            @endif
                            <button type="submit" class="bg-pink-400 hover:bg-pink-500 text-white rounded-lg px-5 py-1.5 font-semibold w-24 ml-auto transition text-sm">
                                Save
                            </button>
                        </div>
                    </form>

                    <!-- Gentle Reminders -->
                    <div class="bg-white rounded-2xl shadow p-6 flex flex-col">
                        <div class="font-bold text-pink-900 mb-2 text-lg flex items-center gap-2"><span
                                class="material-icons text-pink-400">notifications_active</span>Gentle Reminders</div>
                        <ul class="text-pink-700 text-base space-y-1 mb-2">
                            @forelse($topReminders as $reminder)
                                @php
                                    $icon = 'notifications';
                                    $title = 'Unknown Reminder';
                                    $description = '';
                                    if ($reminder->relatedEntity) {
                                        switch ($reminder->type) {
                                            case 'goal':
                                                $icon = 'flag';
                                                $title = $reminder->relatedEntity->title;
                                                $description = $reminder->relatedEntity->description;
                                                break;
                                            case 'challenge':
                                                $icon = 'emoji_events';
                                                $title = $reminder->relatedEntity->title;
                                                $description = $reminder->relatedEntity->description;
                                                break;
                                            case 'daily_checkin':
                                                $icon = 'check_circle';
                                                $title = $reminder->relatedEntity->title;
                                                $description = 'Daily Check-in';
                                                break;
                                        }
                                    }
                                @endphp
                                <li class="flex items-center gap-2">
                                    <span class="material-icons text-pink-300 text-base">{{ $icon }}</span>
                                    <span class="font-semibold">{{ $title }}</span>
                                    @php
                                        $typeLabel = '';
                                        switch ($reminder->type) {
                                            case 'goal':
                                                $typeLabel = 'Goal';
                                                break;
                                            case 'challenge':
                                                $typeLabel = 'Challenge';
                                                break;
                                            case 'daily_checkin':
                                                $typeLabel = 'Daily Check-in';
                                                break;
                                        }
                                    @endphp
                                    @if($typeLabel)
                                        <span class="ml-2 px-2 py-0.5 rounded bg-pink-100 text-pink-700 text-xs font-semibold">{{ $typeLabel }}</span>
                                    @endif
                                </li>
                            @empty
                                <li class="text-pink-500 text-sm">No active reminders. Enjoy your day!</li>
                            @endforelse
                        </ul>
                        <a href="{{ route('reminders.index') }}" class="text-pink-500 text-xs font-semibold ml-auto hover:underline"
                            aria-label="View more reminders">View More</a>
                    </div>

                    <!-- Leaderboard -->
                    <div class="bg-pink-50 rounded-2xl shadow p-6 flex flex-col">
                        <div class="font-bold text-pink-900 mb-4 flex items-center gap-2">
                            <span class="material-icons text-pink-400">emoji_events</span>
                            Top Performers
                        </div>
                        @php
                            $topUsers = \App\Models\User::orderByDesc('xp')
                                ->take(3)
                                ->get()
                                ->map(function ($user, $index) {
                                    $rank = $index + 1;
                                    $colors = [
                                        1 => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'border' => 'border-yellow-400', 'emoji' => '🏆'],
                                        2 => ['bg' => 'bg-gray-200', 'text' => 'text-gray-700', 'border' => 'border-gray-300', 'emoji' => ''],
                                        3 => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700', 'border' => 'border-orange-400', 'emoji' => ''],
                                    ];
                                    return [
                                        'user' => $user,
                                        'rank' => $rank,
                                        'colors' => $colors[$rank]
                                    ];
                                });
                        @endphp

                        <div class="space-y-2">
                            @foreach($topUsers as $data)
                                <div class="bg-white rounded-lg p-3 flex items-center justify-between shadow-sm">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full {{ $data['colors']['bg'] }} flex items-center justify-center font-bold {{ $data['colors']['text'] }} border-2 {{ $data['colors']['border'] }}">
                                            {{ $data['rank'] }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-800">{{ $data['user']->name }}</div>
                                            <div class="text-xs text-pink-500">{{ number_format($data['user']->xp) }} XP</div>
                                        </div>
                                    </div>
                                    @if($data['colors']['emoji'])
                                        <span class="text-xl">{{ $data['colors']['emoji'] }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <a href="{{ route('leaderboard.xp') }}" class="text-pink-500 text-xs font-semibold ml-auto mt-3 hover:underline">
                            View Full Leaderboard
                        </a>
                    </div>

                    <!-- Recent Badges -->
                    <div class="bg-white rounded-2xl shadow p-6 flex flex-col">
                        <div class="font-bold text-pink-900 mb-2 flex items-center gap-2">
                            <span class="material-icons text-pink-400">stars</span>
                            Recent Badges
                        </div>
                        <div class="flex gap-2 mb-2 flex-wrap">
                            @forelse($user->badges()->latest()->take(3)->get() as $badge)
                                @php
                                    $style = $badge->style ?? [];
                                    $icon = $style['icon'] ?? 'emoji_events';
                                    // Convert Font Awesome icon to Material icon if present
                                    if (str_contains($icon, 'fa-')) {
                                        $icon = match(true) {
                                            str_contains($icon, 'id-badge') => 'badge',
                                            str_contains($icon, 'trophy') => 'emoji_events',
                                            str_contains($icon, 'medal') => 'military_tech',
                                            default => 'emoji_events'
                                        };
                                    }
                                @endphp
                                <span class="bg-pink-200 text-pink-800 rounded-full px-4 py-1 text-xs font-semibold flex items-center gap-1">
                                    @if($badge->image_url)
                                        <img src="{{ asset($badge->image_url) }}"
                                             alt="{{ $badge->name }}"
                                             class="w-5 h-5 rounded-full object-contain"
                                        />
                                    @else
                                        <span class="material-icons text-pink-400 text-base">{{ $icon }}</span>
                                    @endif
                                    {{ $badge->name }}
                                </span>
                            @empty
                                <p class="text-pink-700 text-sm">No badges earned yet. Complete challenges to earn badges!</p>
                            @endforelse
                        </div>
                        <a href="{{ route('leaderboard.badges') }}" class="text-pink-500 text-xs font-semibold ml-auto hover:underline">
                            View All Badges
                        </a>
                    </div>
                </div>
            </div>

            <!-- Week in Feelings -->
            <div class="bg-gradient-to-r from-pink-200 to-pink-100 rounded-2xl shadow p-8 w-full mt-2">
                <div class="font-bold text-pink-900 mb-3 text-lg flex items-center gap-2"><span class="material-icons text-pink-400">calendar_month</span>Your Week in Feelings</div>
                <div id="week-moods" class="flex items-center mb-2 overflow-x-auto px-2 sm:px-4 scrollbar-hide sm:justify-between sm:overflow-visible"></div>
                <div class="text-xs md:text-sm text-pink-700 flex items-center"><span class="material-icons text-pink-400 mr-2 text-2xl">auto_awesome</span>Each day is a new opportunity.</div>
            </div>

        </div>
    </div>
</div>

@vite('resources/js/app.js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.getElementById('thought-textarea');
        const charCount = document.getElementById('thought-char-count');
        if (textarea && charCount) {
            textarea.addEventListener('input', function() {
                let val = textarea.value;
                if (val.length > 60) {
                    textarea.value = val.slice(0, 60);
                }
                charCount.textContent = textarea.value.length + ' / 60';
            });
        }
    });
</script>
@endsection

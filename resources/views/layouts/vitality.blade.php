<!DOCTYPE html>
<html lang="en">

@php
    $user = Auth::user();
    $xp = $user->xp ?? 0;
    $credits = $user->credits ?? 0;
    $xpToNextLevel = 500;
    $level = floor($xp / $xpToNextLevel) + 1;
    $xpProgress = $xp % $xpToNextLevel;
    $progressPercent = min(100, ($xpProgress / $xpToNextLevel) * 100);
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Vitality Platform')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');

            if (sidebar.classList.contains('hidden')) {
                // Show sidebar first
                sidebar.classList.remove('hidden');
                // Force a reflow
                sidebar.offsetHeight;
                // Then remove the transform
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                // Add transform first
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
                // Wait for animation to finish before hiding
                setTimeout(() => {
                    sidebar.classList.add('hidden');
                }, 300);
            }
        }

        function toggleLogOut() {
            const menu = document.getElementById('logout-dropdown');
            menu.classList.toggle('hidden');
        }

        document.addEventListener('click', function (event) {
            const menu = document.getElementById('logout-dropdown');
            const button = event.target.closest('button');
            if (!menu.contains(event.target) && !button) {
                menu.classList.add('hidden');
            }
        });
    </script>
</head>

<body class="bg-gray-50 min-h-screen">
<!-- Mobile Sidebar Toggle -->
<button class="md:hidden fixed top-4 left-4 z-30 bg-pink-400 text-white rounded-full p-2 shadow-lg"
        aria-label="Open sidebar" onclick="toggleSidebar()">
    <span class="material-icons">menu</span>
</button>

<!-- Sidebar Backdrop -->
<div id="sidebar-backdrop" class="fixed inset-0 bg-black bg-opacity-30 z-20 hidden md:hidden transition-opacity duration-300"
     onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<aside id="sidebar"
       class="w-72 bg-gradient-to-b from-pink-200 to-pink-100 p-0 flex flex-col min-h-screen shadow-xl border-r border-pink-100 fixed md:fixed z-30 transition-all duration-300 ease-in-out transform -translate-x-full md:translate-x-0 hidden md:flex h-screen top-0 left-0">
    <!-- User Card -->
    <div class="p-4 md:p-6 pb-2 md:pb-4 border-b border-pink-100 flex-shrink-0">
        <div class="flex items-center gap-4 mb-3">
            <div class="relative inline-block text-left">
                <button onclick="toggleLogOut()"
                        class="w-12 h-12 md:w-14 md:h-14 rounded-full bg-pink-300 flex items-center justify-center text-2xl font-bold text-white focus:outline-none">
                    {{ strtoupper(substr(explode(' ', Auth::user()->name)[0] ?? '', 0, 1) . substr(explode(' ', Auth::user()->name)[1] ?? '', 0, 1)) }}
                </button>
                <div id="logout-dropdown"
                     class="hidden absolute left-16 top-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                    <div class="px-4 py-3">
                        <p class="text-sm font-medium text-pink-900">{{ Auth::user()->name }}</p>
                        <p class="text-sm text-pink-600">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="py-1">
                        <a href="#"
                           class="flex items-center gap-2 px-4 py-2 text-sm text-pink-700 hover:bg-pink-50">
                            <span class="material-icons text-base">person</span> Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center gap-2 px-4 py-2 text-sm text-pink-700 hover:bg-pink-50">
                                <span class="material-icons text-base">logout</span> Log out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div>
                <div class="font-semibold text-base md:text-lg text-pink-900">{{ Auth::user()->name }}</div>
                <div class="text-xs text-pink-700">Wellness Seeker</div>
            </div>
        </div>
        <div class="flex items-center justify-between mb-2">
            <div class="flex items-center gap-2">
                <span class="text-xs bg-pink-300 text-white rounded px-2 py-0.5"
                      id="sidebar-level">Level {{ $level }}</span>
                <span class="text-xs text-pink-700" id="sidebar-xp">{{ $xpProgress }} / {{ $xpToNextLevel }} XP</span>
            </div>
            <x-notifications :notifications="session('notifications', [])"/>
        </div>
        <div class="w-full h-2 bg-pink-100 rounded-full overflow-hidden mb-2">
            <div id="sidebar-xp-bar" class="h-full bg-pink-400 rounded-full transition-all duration-300 ease-in-out"
                 style="width: {{ $progressPercent }}%"></div>
        </div>
        <div class="text-xs text-pink-700 font-semibold flex items-center gap-1">
            <span class="material-icons text-pink-400 text-base">monetization_on</span>
            <span id="sidebar-credits">{{ $credits }} Credits</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 flex flex-col justify-between p-2 md:p-4 overflow-y-auto">
        <div class="space-y-4">
            @auth
                @if(auth()->user()->is_admin)
                    <div>
                        <div class="text-xs text-pink-700 font-bold uppercase tracking-wider mb-2">Administrator</div>
                        <ul class="space-y-1">
                            <li>
                                <a href="{{ route('dashboard') }}"
                                   class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition-all duration-200
                                    {{ request()->routeIs('dashboard') ? 'bg-white/90 text-pink-900' : 'text-pink-900 hover:bg-pink-100 hover:translate-x-1' }}">
                                    <span class="material-icons">terminal</span>Dashboard
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif
            @endauth
            <div>
                <div class="text-xs text-pink-700 font-bold uppercase tracking-wider mb-2">Main</div>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('home') }}"
                           class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition-all duration-200
                                {{ request()->routeIs('home') ? 'bg-white/90 text-pink-900' : 'text-pink-900 hover:bg-pink-100 hover:translate-x-1' }}">
                            <span class="material-icons">home</span> Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('diary') }}"
                           class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition-all duration-200
                                {{ request()->routeIs('diary') ? 'bg-white/90 text-pink-900' : 'text-pink-900 hover:bg-pink-100 hover:translate-x-1' }}">
                            <span class="material-icons">book</span> Diary
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('checkins.index') }}"
                           class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition-all duration-200
                                {{ request()->routeIs('checkins.index') ? 'bg-white/90 text-pink-900' : 'text-pink-900 hover:bg-pink-100 hover:translate-x-1' }}">
                            <span class="material-icons">check_circle</span> Daily Check-ins
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reminders.index') }}"
                           class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition-all duration-200
                                {{ request()->routeIs('reminders.index') ? 'bg-white/90 text-pink-900' : 'text-pink-900 hover:bg-pink-100 hover:translate-x-1' }}">
                            <span class="material-icons">notifications</span> Reminders
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('articles.index') }}"
                           class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition-all duration-200
                                {{ request()->routeIs('articles.index') ? 'bg-white/90 text-pink-900' : 'text-pink-900 hover:bg-pink-100 hover:translate-x-1' }}">
                            <span class="material-icons">article</span> Articles
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('capychat') }}"
                           class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition-all duration-200
                                {{ request()->routeIs('capychat') ? 'bg-white/90 text-pink-900' : 'text-pink-900 hover:bg-pink-100 hover:translate-x-1' }}">
                            <img src="/images/capybara-icon.svg" alt="Capy Chat" class="w-6 h-6 inline-block align-middle" /> Capy Chat
                            <span id="capy-unread-bubble" class="absolute right-2 top-2 bg-pink-400 text-white text-xs font-bold rounded-full px-2 py-0.5 hidden"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('goals') }}"
                           class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition-all duration-200
                                {{ request()->routeIs('my-goals') ? 'bg-white/90 text-pink-900' : 'text-pink-900 hover:bg-pink-100 hover:translate-x-1' }}">
                            <span class="material-icons">flag</span> My Goals
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <div class="text-xs text-pink-700 font-bold uppercase tracking-wider mb-2">Challenges</div>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('challenges.index') }}"
                           class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition-all duration-200
                                {{ request()->routeIs('challenges.*') ? 'bg-white/90 text-pink-900' : 'text-pink-900 hover:bg-pink-100 hover:translate-x-1' }}">
                            <span class="material-icons">emoji_events</span> Challenges
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('leaderboard.xp') }}"
                           class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition-all duration-200
                                {{ request()->routeIs('leaderboard.*') ? 'bg-white/90 text-pink-900' : 'text-pink-900 hover:bg-pink-100 hover:translate-x-1' }}">
                            <span class="material-icons">leaderboard</span> Leaderboard
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <div class="text-xs text-pink-700 font-bold uppercase tracking-wider mb-2">Customization</div>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('store') }}"
                           class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition-all duration-200
                                {{ request()->routeIs('store') ? 'bg-white/90 text-pink-900' : 'text-pink-900 hover:bg-pink-100 hover:translate-x-1' }}">
                            <span class="material-icons">store</span> Store
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('appearance') }}"
                           class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition-all duration-200
                                {{ request()->routeIs('appearance') ? 'bg-white/90 text-pink-900' : 'text-pink-900 hover:bg-pink-100 hover:translate-x-1' }}">
                            <span class="material-icons">palette</span> Appearance
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('settings.index') }}"
                           class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition-all duration-200
                                {{ request()->routeIs('settings.*') ? 'bg-white/90 text-pink-900' : 'text-pink-900 hover:bg-pink-100 hover:translate-x-1' }}">
                            <span class="material-icons">settings</span> Settings
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="text-xs text-pink-700 p-2 md:p-4 flex justify-center text-center flex-shrink-0">
        Syntess Vitality<br>Your daily wellness companion
    </div>
</aside>

<!-- Main Content -->
<main class="flex-1 bg-gray-50 min-h-screen">
    @yield('content')
</main>

<!-- Toast Notifications -->
@if(session('toast_notification'))
    <x-toast-notification :notification="session('toast_notification')"/>
@endif

@stack('scripts')
</body>
</html>

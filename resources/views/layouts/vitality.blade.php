<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Vitality Platform')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex">
    <!-- Sidebar -->
    <aside class="w-72 bg-gradient-to-b from-pink-200 to-pink-100 p-6 flex flex-col justify-between min-h-screen shadow-lg">
        <div>
            <!-- User Info -->
            <div class="flex items-center gap-4 mb-8">
                <div class="w-14 h-14 rounded-full bg-pink-300 flex items-center justify-center text-2xl font-bold text-white">JD</div>
                <div>
                    <div class="font-semibold text-lg text-pink-900">John Doe</div>
                    <div class="text-xs text-pink-700">Wellness Seeker</div>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-xs bg-pink-300 text-white rounded px-2 py-0.5">Level 5</span>
                        <span class="text-xs text-pink-700">450 / 500 XP</span>
                    </div>
                </div>
            </div>
            <!-- Navigation -->
            <nav class="flex flex-col gap-2">
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg bg-white/80 text-pink-900 font-medium hover:bg-pink-100 transition"><span class="material-icons">home</span> Home</a>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-pink-900 hover:bg-pink-100 transition"><span class="material-icons">book</span> Diary</a>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-pink-900 hover:bg-pink-100 transition"><span class="material-icons">check_circle</span> Daily Check-ins</a>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-pink-900 hover:bg-pink-100 transition"><span class="material-icons">article</span> Articles</a>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-pink-900 hover:bg-pink-100 transition"><span class="material-icons">flag</span> My Goals</a>
                <div class="mt-4 text-xs text-pink-700 font-semibold uppercase tracking-wider">Challenges</div>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-pink-900 hover:bg-pink-100 transition"><span class="material-icons">emoji_events</span> Challenges</a>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-pink-900 hover:bg-pink-100 transition"><span class="material-icons">flag</span> My Goals</a>
                <div class="mt-4 text-xs text-pink-700 font-semibold uppercase tracking-wider">Customization</div>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-pink-900 hover:bg-pink-100 transition"><span class="material-icons">store</span> Store</a>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-pink-900 hover:bg-pink-100 transition"><span class="material-icons">palette</span> Appearance</a>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-pink-900 hover:bg-pink-100 transition"><span class="material-icons">settings</span> Settings</a>
            </nav>
        </div>
        <div class="text-xs text-pink-700 mt-8">Syntess Vital<br> Your daily wellness companion</div>
    </aside>
    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto">
        @yield('content')
    </main>
</body>
</html> 
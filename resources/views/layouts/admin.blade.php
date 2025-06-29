<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('hidden');
            document.getElementById('sidebar-backdrop').classList.toggle('hidden');
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen">

<div id="flash-message-container" class="fixed top-4 right-4 z-50 w-full max-w-sm">
    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg shadow-lg mb-4 flex justify-between items-center animate-fade-in-down" role="alert">
            <span>{{ session('success') }}</span>
            <button type="button" class="ml-4 text-white hover:text-gray-100 text-lg leading-none" onclick="this.parentElement.remove();">&times;</button>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-500 text-white p-4 rounded-lg shadow-lg mb-4 flex justify-between items-center animate-fade-in-down" role="alert">
            <span>{{ session('error') }}</span>
            <button type="button" class="ml-4 text-white hover:text-gray-100 text-lg leading-none" onclick="this.parentElement.remove();">&times;</button>
        </div>
    @endif

    @if (session('warning'))
        <div class="bg-yellow-500 text-white p-4 rounded-lg shadow-lg mb-4 flex justify-between items-center animate-fade-in-down" role="alert">
            <span>{{ session('warning') }}</span>
            <button type="button" class="ml-4 text-white hover:text-gray-100 text-lg leading-none" onclick="this.parentElement.remove();">&times;</button>
        </div>
    @endif

    @if (session('info'))
        <div class="bg-blue-500 text-white p-4 rounded-lg shadow-lg mb-4 flex justify-between items-center animate-fade-in-down" role="alert">
            <span>{{ session('info') }}</span>
            <button type="button" class="ml-4 text-white hover:text-gray-100 text-lg leading-none" onclick="this.parentElement.remove();">&times;</button>
        </div>
    @endif
</div>

<button class="md:hidden fixed top-4 left-4 z-30 bg-gray-800 text-white rounded-full p-2 shadow-lg"
        aria-label="Open sidebar" onclick="toggleSidebar()">
    <span class="material-icons">menu</span>
</button>
<div id="sidebar-backdrop" class="fixed inset-0 bg-black bg-opacity-30 z-20 hidden md:hidden"
     onclick="toggleSidebar()"></div>
<aside id="sidebar"
       class="w-72 bg-gradient-to-b from-gray-100 to-gray-50 p-0 flex flex-col min-h-screen shadow-xl border-r border-gray-100 fixed md:fixed z-30 transition-transform duration-200 md:translate-x-0 hidden md:flex h-screen top-0 left-0">
    <div class="p-6 pb-4 border-b border-gray-100">
        <div class="flex items-center gap-4 mb-3">
            <div class="relative inline-block text-left">
                <div
                    class="w-14 h-14 rounded-full bg-gray-300 flex items-center justify-center text-2xl font-bold text-white focus:outline-none">
                    {{ strtoupper(substr(explode(' ', Auth::user()->name)[0] ?? '', 0, 1) . substr(explode(' ', Auth::user()->name)[1] ?? '', 0, 1)) }}
                </div>
            </div>
            <div>
                <div class="font-semibold text-lg text-gray-900">{{ Auth::user()->name }}</div>
                <div class="text-xs text-gray-700">Administrator</div>
            </div>
        </div>
    </div>
    <nav class="flex-1 flex flex-col justify-between p-4">
        <div>
            <div class="text-xs text-gray-600 font-bold uppercase tracking-wider mb-2 mt-2">Main</div>
            <ul class="space-y-1">
                <li><a href="{{ route('home') }}"
                       class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition
                            {{ request()->routeIs('home') ? 'bg-white/90 text-gray-900' : 'text-gray-900 hover:bg-gray-200' }}">

                        <span class="material-icons">home</span> Home
                    </a></li>
                <li><a href="{{ route('dashboard') }}"
                       class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition
                            {{ request()->routeIs('dashboard') ? 'bg-white/100 text-gray-900' : 'text-gray-900 hover:bg-gray-200' }}">

                        <span class="material-icons">dashboard</span> Dashboard
                    </a></li>
                <li><a href="{{ route('admin.articles.index') }}"
                       class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition
                            {{ request()->routeIs('admin.articles.index') ? 'bg-white/100 text-gray-900' : 'text-gray-900 hover:bg-gray-200' }}">
                        <span class="material-icons">article</span> Manage Articles
                    </a></li>
                <li><a href="{{ route('admin.challenges.index') }}"
                       class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition
                            {{ request()->routeIs('admin.challenges.index') ? 'bg-white/100 text-gray-900' : 'text-gray-900 hover:bg-gray-200' }}">
                        <span class="material-icons">emoji_events</span> Manage Challenges
                    </a></li>
                <li><a href="{{ route('admin.activity_logs.index') }}"

                       class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium transition
                            {{ request()->routeIs('admin.activity_logs.index') ? 'bg-white/100 text-gray-900' : 'text-gray-900 hover:bg-gray-200' }}">
                        <span class="material-icons">history</span> Activity log
                    </a></li>
            </ul>
        </div>
    </nav>
    <div class="text-xs text-gray-600 p-4 flex justify-center text-center">Syntess Vital Admin<br>Platform Management
    </div>
</aside>
<main class="flex-1 bg-gray-50 min-h-screen p-4 md:p-8 md:ml-72 flex justify-center"> {{-- Added 'flex justify-center', removed 'max-w-7xl mx-auto' --}}
    <div class="w-full max-w-7xl">
        @yield('content')
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const flashMessages = document.querySelectorAll('#flash-message-container > div');
        flashMessages.forEach(message => {
            setTimeout(() => {
                message.classList.add('animate-fade-out-up');
                message.addEventListener('animationend', () => message.remove());
            }, 4000);
        });
    });
</script>
<style>
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeOutUp {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-20px);
        }
    }

    .animate-fade-in-down {
        animation: fadeInDown 0.5s ease-out forwards;
    }

    .animate-fade-out-up {
        animation: fadeOutUp 0.5s ease-in forwards;
    }
</style>

@stack('scripts')

</body>
</html>

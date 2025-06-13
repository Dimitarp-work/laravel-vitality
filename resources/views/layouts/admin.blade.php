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
    <!-- Mobile sidebar toggle -->
    <button class="md:hidden fixed top-4 left-4 z-30 bg-gray-800 text-white rounded-full p-2 shadow-lg" aria-label="Open sidebar" onclick="toggleSidebar()">
        <span class="material-icons">menu</span>
    </button>
    <!-- Sidebar backdrop for mobile -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-black bg-opacity-30 z-20 hidden md:hidden" onclick="toggleSidebar()"></div>
    <!-- Sidebar -->
    <aside id="sidebar" class="w-72 bg-gradient-to-b from-gray-100 to-gray-50 p-0 flex flex-col min-h-screen shadow-xl border-r border-gray-100 fixed md:fixed z-30 transition-transform duration-200 md:translate-x-0 hidden md:flex h-screen top-0 left-0">
        <!-- Admin Profile Card -->
        <div class="p-6 pb-4 border-b border-gray-100">
            <div class="flex items-center gap-4 mb-2">
                <div class="w-14 h-14 rounded-full bg-gray-400 flex items-center justify-center text-2xl font-bold text-white">
                    <span class="material-icons">admin_panel_settings</span>
                </div>
                <div>
                    <div class="font-semibold text-lg text-gray-900">Jane Doe</div>
                    <div class="text-xs text-gray-600">Administrator</div>
                </div>
            </div>
        </div>
        <!-- Navigation -->
        <nav class="flex-1 flex flex-col justify-between p-4">
            <div>
                <div class="text-xs text-gray-600 font-bold uppercase tracking-wider mb-2 mt-2">Main</div>
                <ul class="space-y-1">
                    <li><a href="/dashboard" class="flex items-center gap-3 px-4 py-2 rounded-lg font-medium text-gray-900 bg-white/90 hover:bg-gray-200 hover:border-l-4 hover:border-pink-400 transition border-l-4 border-transparent"><span class="material-icons">dashboard</span> Dashboard</a></li>
                    <li><a href="/articles/manage" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-900 hover:bg-gray-200 hover:border-l-4 hover:border-pink-400 transition border-l-4 border-transparent"><span class="material-icons">article</span> Manage Articles</a></li>
                    <li><a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-900 hover:bg-gray-200 hover:border-l-4 hover:border-pink-400 transition border-l-4 border-transparent"><span class="material-icons">group</span> Manage Users</a></li>
                    <li><a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-900 hover:bg-gray-200 hover:border-l-4 hover:border-pink-400 transition border-l-4 border-transparent"><span class="material-icons">analytics</span> Analytics</a></li>
                </ul>
                <div class="text-xs text-gray-600 font-bold uppercase tracking-wider mb-2 mt-6">Settings</div>
                <ul class="space-y-1">
                    <li><a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-900 hover:bg-gray-200 hover:border-l-4 hover:border-pink-400 transition border-l-4 border-transparent"><span class="material-icons">settings</span> Site Settings</a></li>
                    <li><a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-900 hover:bg-gray-200 hover:border-l-4 hover:border-pink-400 transition border-l-4 border-transparent"><span class="material-icons">history</span> Activity Log</a></li>
                </ul>
            </div>
        </nav>
        <div class="text-xs text-gray-600 p-4 flex justify-center text-center">Syntess Vital Admin<br>Platform Management</div>
    </aside>
    <!-- Main Content -->
    <main class="flex-1 bg-gray-50 min-h-screen p-4 md:p-8 md:ml-72 max-w-7xl mx-auto">
        @yield('content')
    </main>
</body>
</html>

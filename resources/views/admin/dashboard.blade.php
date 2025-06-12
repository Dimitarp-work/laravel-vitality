@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

    {{-- Blade Helper Function for Growth Percentage Display --}}
    @php
        function renderGrowthPercentage($percentage) {
            $class = 'text-gray-600'; // Default for 0
            $value = '';
            $symbol = '';

            if ($percentage === null) {
                $value = 'New';
                $class = 'text-green-600'; // Or any color you prefer for "New"
            } elseif ($percentage > 0) {
                $class = 'text-green-600';
                $symbol = '+';
                $value = number_format($percentage, 1) . '%';
            } elseif ($percentage < 0) {
                $class = 'text-red-600';
                $value = number_format($percentage, 1) . '%';
            } else {
                $value = '0%';
            }

            return "<span class=\"$class text-sm font-semibold\">$symbol$value</span>";
        }
    @endphp

    <div class="w-full max-w-7xl mx-auto flex flex-col gap-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-theme-900 mb-1 flex items-center gap-2">
                    <span class="material-icons text-theme-400">admin_panel_settings</span>
                    Admin Dashboard
                </h1>
                <p class="text-theme-700 text-base">Welcome back! Here's what's happening today.</p>
            </div>
            <div class="flex gap-3">
                <button class="bg-white hover:bg-gray-50 text-theme-700 border border-theme-200 rounded-lg px-6 py-2 font-semibold flex items-center gap-2 transition">
                    <span class="material-icons text-base">download</span>
                    Export
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-theme-100 flex items-center justify-center">
                        <span class="material-icons text-theme-400 text-2xl">article</span>
                    </div>
                </div>
                <div class="text-2xl font-bold text-theme-900 mb-1">{{ $totalArticles }}</div>
                <div class="text-theme-700 text-sm">Total Articles</div>
                {{-- Display detailed weekly and monthly growth below --}}
                <div class="text-xs text-theme-500 mt-2 flex flex-col gap-1">
                    <span class="font-medium">Weekly Change: @php echo renderGrowthPercentage($articlesWeeklyGrowth); @endphp</span>
                    <span class="font-medium">Monthly Change: @php echo renderGrowthPercentage($articlesMonthlyGrowth); @endphp</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                        <span class="material-icons text-green-400 text-2xl">group</span>
                    </div>
                </div>
                <div class="text-2xl font-bold text-theme-900 mb-1">{{ number_format($totalUsers) }}</div>
                <div class="text-theme-700 text-sm">Active Users</div>
                {{-- Display detailed weekly and monthly growth for users below --}}
                <div class="text-xs text-theme-500 mt-2 flex flex-col gap-1">
                    <span class="font-medium">Weekly Change: @php echo renderGrowthPercentage($usersWeeklyGrowth); @endphp</span>
                    <span class="font-medium">Monthly Change: @php echo renderGrowthPercentage($usersMonthlyGrowth); @endphp</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                        <span class="material-icons text-blue-400 text-2xl">visibility</span>
                    </div>
                    <span class="text-blue-400 text-sm font-semibold">+24%</span>
                </div>
                <div class="text-2xl font-bold text-theme-900 mb-1">45.2K</div>
                <div class="text-theme-700 text-sm">Total Views</div>
            </div>

            <div class="bg-white rounded-2xl shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center">
                        <span class="material-icons text-purple-400 text-2xl">trending_up</span>
                    </div>
                    <span class="text-purple-400 text-sm font-semibold">+18%</span>
                </div>
                <div class="text-2xl font-bold text-theme-900 mb-1">68%</div>
                <div class="text-theme-700 text-sm">Engagement Rate</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-2xl shadow p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="font-semibold text-lg text-theme-900 flex items-center gap-2">
                        <span class="material-icons text-theme-400">article</span>
                        Recent Articles
                    </h2>
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <input type="text" placeholder="Search articles..." class="pl-10 pr-4 py-2 border border-theme-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-theme-400 focus:border-transparent">
                            <span class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-theme-400 text-base">search</span>
                        </div>
                        <button class="p-2 hover:bg-theme-50 rounded-lg transition">
                            <span class="material-icons text-theme-400">filter_list</span>
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-theme-100">
                        <thead>
                        <tr class="bg-theme-50">
                            <th class="px-4 py-3 text-xs font-semibold text-theme-700 uppercase tracking-wider text-left">Title</th>
                            <th class="px-4 py-3 text-xs font-semibold text-theme-700 uppercase tracking-wider text-left">Date</th>
                            <th class="px-4 py-3 text-xs font-semibold text-theme-700 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-theme-100">
                        @forelse ($recentArticles as $article)
                            <tr class="hover:bg-theme-50 transition">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        {{-- Conditional display of article image or a fallback icon --}}
                                        <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0">
                                            @if ($article->image)
                                                <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                                            @else
                                                {{-- Fallback icon if no image --}}
                                                <div class="w-full h-10 bg-theme-100 flex items-center justify-center">
                                                    <span class="material-icons text-theme-400">article</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            {{-- Article title as a link to the article, no underline --}}
                                            <a href="{{ route('articles.show', $article) }}" class="font-medium text-theme-900 no-underline hover:text-theme-700">
                                                {{ $article->title }}
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-theme-700">{{ $article->created_at->format('Y-m-d') }}</td>
                                <td class="px-4 py-3 text-right relative">
                                    {{-- Alpine.js x-data initializes the dropdown state --}}
                                    <div x-data="{ open: false }" @click.outside="open = false" class="inline-block relative">
                                        <button @click="open = !open" class="p-1 hover:bg-theme-100 rounded transition" title="More actions">
                                            <span class="material-icons text-theme-400 text-base">more_vert</span>
                                        </button>

                                        {{-- Dropdown Menu --}}
                                        <div x-show="open"
                                             x-transition:enter="transition ease-out duration-100"
                                             x-transition:enter-start="transform opacity-0 scale-95"
                                             x-transition:enter-end="transform opacity-100 scale-100"
                                             x-transition:leave="transition ease-in duration-75"
                                             x-transition:leave-start="transform opacity-100 scale-100"
                                             x-transition:leave-end="transform opacity-0 scale-95"
                                             class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10 origin-top-right">
                                            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                                {{-- Edit Button --}}
                                                <a href="{{ route('articles.edit', $article) }}"
                                                   class="flex items-center gap-2 px-4 py-2 text-sm text-blue-700 hover:bg-blue-50 hover:text-blue-900 transition"
                                                   role="menuitem">
                                                    <span class="material-icons text-base">edit</span>Edit
                                                </a>

                                                {{-- Delete Form/Button --}}
                                                <form action="{{ route('articles.destroy', $article->id) }}" method="POST"
                                                      onsubmit="return confirm('Are you sure you want to delete this article?');"
                                                      class="block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-50 hover:text-red-900 transition"
                                                            role="menuitem">
                                                        <span class="material-icons text-base">delete</span>Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-center text-theme-700">No recent articles found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="flex items-center justify-between mt-6">
                    <div class="text-sm text-theme-700">
                        Showing <span class="font-medium">1</span> to <span class="font-medium">{{ count($recentArticles) }}</span> of <span class="font-medium">{{ $totalArticles }}</span> results
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="px-3 py-1 border border-theme-200 rounded-lg text-theme-700 hover:bg-theme-50 transition">Previous</button>
                        <button class="px-3 py-1 bg-theme-400 text-white rounded-lg hover:bg-theme-500 transition">1</button>
                        <button class="px-3 py-1 border border-theme-200 rounded-lg text-theme-700 hover:bg-theme-50 transition">2</button>
                        <button class="px-3 py-1 border border-theme-200 rounded-lg text-theme-700 hover:bg-theme-50 transition">Next</button>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-6">
                <div class="bg-white rounded-2xl shadow p-6">
                    <h2 class="font-semibold text-lg text-theme-900 mb-4 flex items-center gap-2">
                        <span class="material-icons text-theme-400">bolt</span>
                        Quick Actions
                    </h2>
                    <div class="grid grid-cols-2 gap-3">
                        <button class="p-4 bg-theme-50 rounded-xl hover:bg-theme-100 transition flex flex-col items-center gap-2">
                            <span class="material-icons text-theme-400">add_circle</span>
                            <span class="text-sm font-medium text-theme-700">New Article</span>
                        </button>
                        <button class="p-4 bg-theme-50 rounded-xl hover:bg-theme-100 transition flex flex-col items-center gap-2">
                            <span class="material-icons text-theme-400">group_add</span>
                            <span class="text-sm font-medium text-theme-700">Add User</span>
                        </button>
                        <button class="p-4 bg-theme-50 rounded-xl hover:bg-theme-100 transition flex flex-col items-center gap-2">
                            <span class="material-icons text-theme-400">analytics</span>
                            <span class="text-sm font-medium text-theme-700">Analytics</span>
                        </button>
                        <button class="p-4 bg-theme-50 rounded-xl hover:bg-theme-100 transition flex flex-col items-center gap-2">
                            <span class="material-icons text-theme-400">settings</span>
                            <span class="text-sm font-medium text-theme-700">Settings</span>
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow p-6">
                    <h2 class="font-semibold text-lg text-theme-900 mb-4 flex items-center gap-2">
                        <span class="material-icons text-theme-400">history</span>
                        Recent Activity
                    </h2>
                    <div class="space-y-4">
                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                <span class="material-icons text-green-400 text-base">edit</span>
                            </div>
                            <div>
                                <div class="text-sm text-theme-900">Article "Mindfulness for Beginners" was updated</div>
                                <div class="text-xs text-theme-500">2 hours ago</div>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                <span class="material-icons text-blue-400 text-base">person_add</span>
                            </div>
                            <div>
                                <div class="text-sm text-theme-900">New user registered</div>
                                <div class="text-xs text-theme-500">4 hours ago</div>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center">
                                <span class="material-icons text-purple-400 text-base">article</span>
                            </div>
                            <div>
                                <div class="text-sm text-theme-900">New article published</div>
                                <div class="text-xs text-theme-500">1 day ago</div>
                            </div>
                        </div>
                    </div>
                    <button class="text-theme-400 text-sm font-medium mt-4 hover:text-theme-500 transition">View All Activity</button>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="font-semibold text-lg text-theme-900 mb-4 flex items-center gap-2">
            <span class="material-icons text-theme-400">history_edu</span>
            XP & Credit Logs
        </h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-theme-100">
                <thead>
                <tr class="bg-theme-50">
                    <th class="px-4 py-3 text-xs font-semibold text-theme-700 uppercase tracking-wider text-left">User</th>
                    <th class="px-4 py-3 text-xs font-semibold text-theme-700 uppercase tracking-wider text-left">XP Change</th>
                    <th class="px-4 py-3 text-xs font-semibold text-theme-700 uppercase tracking-wider text-left">Credit Change</th>
                    <th class="px-4 py-3 text-xs font-semibold text-theme-700 uppercase tracking-wider text-left">Reason</th>
                    <th class="px-4 py-3 text-xs font-semibold text-theme-700 uppercase tracking-wider text-left">Timestamp</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-theme-100">
                @foreach ($logs as $log)
                    <tr class="hover:bg-theme-50 transition">
                        <td class="px-4 py-3 text-theme-700">{{ $log->user->name }}</td>
                        <td class="px-4 py-3 text-theme-900 font-medium {{ $log->xp_change > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $log->xp_change }}
                        </td>
                        <td class="px-4 py-3 text-theme-900 font-medium {{ $log->credit_change > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $log->credit_change }}
                        </td>
                        <td class="px-4 py-3 text-theme-700">{{ $log->reason }}</td>
                        <td class="px-4 py-3 text-theme-500 text-sm">{{ $log->created_at->diffForHumans() }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

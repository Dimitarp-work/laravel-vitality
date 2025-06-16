@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    @php
        function renderGrowthPercentage($percentage) {
            $class = 'text-gray-600';
            $value = '';
            $symbol = '';

            if ($percentage === null) {
                $value = 'New';
                $class = 'text-green-600';
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

        function formatK($number) {
            if ($number >= 1000) {
                return number_format($number / 1000, 1) . 'K';
            }
            return number_format($number);
        }
    @endphp

    <div class="w-full max-w-7xl mx-auto flex flex-col gap-8">
        <div class="flex flex-col md:flex-row md::items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-theme-900 mb-1 flex items-center gap-2">
                    <span class="material-icons text-theme-400">admin_panel_settings</span>
                    Admin Dashboard
                </h1>
                <p class="text-theme-700 text-base">Welcome back! Here's what's happening today.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-theme-100 flex items-center justify-center">
                        <span class="material-icons text-theme-400">article</span>
                    </div>
                </div>
                <div class="text-2xl font-bold text-theme-900 mb-1">{{ $totalArticles }}</div>
                <div class="text-theme-700 text-sm">Total Articles</div>
                <div class="text-xs text-theme-500 mt-2 flex flex-col gap-1">
                    <span
                        class="font-medium">Weekly Change: @php echo renderGrowthPercentage($articlesWeeklyGrowth); @endphp</span>
                    <span
                        class="font-medium">Monthly Change: @php echo renderGrowthPercentage($articlesMonthlyGrowth); @endphp</span>
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
                <div class="text-xs text-theme-500 mt-2 flex flex-col gap-1">
                    <span
                        class="font-medium">Weekly Change: @php echo renderGrowthPercentage($usersWeeklyGrowth); @endphp</span>
                    <span
                        class="font-medium">Monthly Change: @php echo renderGrowthPercentage($usersMonthlyGrowth); @endphp</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                        <span class="material-icons text-blue-400 text-2xl">visibility</span>
                    </div>
                </div>
                <div class="text-2xl font-bold text-theme-900 mb-1">{{ formatK($totalViews) }}</div>
                <div class="text-theme-700 text-sm">Total Views</div>
                <div class="text-xs text-theme-500 mt-2 flex flex-col gap-1">
                    <span
                        class="font-medium">Weekly Change: @php echo renderGrowthPercentage($viewsWeeklyGrowth); @endphp</span>
                    <span
                        class="font-medium">Monthly Change: @php echo renderGrowthPercentage($viewsMonthlyGrowth); @endphp</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center">
                        <span class="material-icons text-purple-400 text-2xl">trending_up</span>
                    </div>
                </div>
                <div class="text-2xl font-bold text-theme-900 mb-1">
                    {{ number_format($totalEngagementRate, 1) }}%
                </div>
                <div class="text-theme-700 text-sm">Engagement Rate</div>
                <div class="text-xs text-theme-500 mt-2 flex flex-col gap-1">
                    <span class="font-medium">Weekly Change: @php echo renderGrowthPercentage($engagementRateWeeklyGrowth); @endphp</span>
                    <span class="font-medium">Monthly Change: @php echo renderGrowthPercentage($engagementRateMonthlyGrowth); @endphp</span>
                </div>
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
                        <form action="{{ route('dashboard') }}" method="GET" class="relative">
                            <input type="text" name="search" placeholder="Search articles..."
                                   value="{{ request('search') }}"
                                   class="pl-10 pr-4 py-2 border border-theme-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-theme-400 focus:border-transparent">
                            <span
                                class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-theme-400 text-base">search</span>
                        </form>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-theme-100">
                        <thead>
                        <tr class="bg-theme-50">
                            <th class="px-4 py-3 text-xs font-semibold text-theme-700 uppercase tracking-wider text-left">
                                Title
                            </th>
                            <th class="px-4 py-3 text-xs font-semibold text-theme-700 uppercase tracking-wider text-left">
                                Date
                            </th>
                            <th class="px-4 py-3 text-xs font-semibold text-theme-700 uppercase tracking-wider text-right">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-theme-100">
                        @forelse ($recentArticles as $article)
                            <tr class="hover:bg-theme-50 transition">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0">
                                            @if ($article->image)
                                                <img src="{{ asset('storage/' . $article->image) }}"
                                                     alt="{{ $article->title }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-10 bg-theme-100 flex items-center justify-center">
                                                    <span class="material-icons text-theme-400">article</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <a href="{{ route('articles.show', $article) }}"
                                               class="font-medium text-theme-900 no-underline hover:text-theme-700">
                                                {{ $article->title }}
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-theme-700">{{ $article->created_at->format('Y-m-d') }}</td>
                                <td class="px-4 py-3 text-right relative">
                                    <div x-data="{ open: false }" @click.outside="open = false"
                                         class="inline-block relative">
                                        <button @click="open = !open" class="p-1 hover:bg-theme-100 rounded transition"
                                                title="More actions">
                                            <span class="material-icons text-theme-400 text-base">more_vert</span>
                                        </button>

                                        <div x-show="open"
                                             x-transition:enter="transition ease-out duration-100"
                                             x-transition:enter-start="transform opacity-0 scale-95"
                                             x-transition:enter-end="transform opacity-100 scale-100"
                                             x-transition:leave="transition ease-in duration-75"
                                             x-transition:leave-start="transform opacity-100 scale-100"
                                             x-transition:leave-end="transform opacity-0 scale-95"
                                             class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10 origin-top-right">
                                            <div class="py-1" role="menu" aria-orientation="vertical"
                                                 aria-labelledby="options-menu">
                                                <a href="{{ route('articles.edit', $article) }}"
                                                   class="flex items-center gap-2 px-4 py-2 text-sm text-blue-700 hover:bg-blue-50 hover:text-blue-900 transition"
                                                   role="menuitem">
                                                    <span class="material-icons text-base">edit</span>Edit
                                                </a>

                                                <button type="button"
                                                        onclick="window.ModalUtils.openDeleteModal('{{ $article->id }}', '{{ url('articles') }}')"
                                                        class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-50 hover:text-red-900 transition"
                                                        role="menuitem">
                                                    <span class="material-icons text-base">delete</span>Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-center text-theme-700">No recent articles found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex items-center justify-between mt-6">
                    <div class="text-sm text-theme-700">
                        Showing <span class="font-medium">{{ $recentArticles->firstItem() }}</span> to
                        <span class="font-medium">{{ $recentArticles->lastItem() }}</span> of
                        <span class="font-medium">{{ $recentArticles->total() }}</span> results
                    </div>
                    <div class="flex items-center gap-2">
                        {{ $recentArticles->links('pagination::tailwind') }}
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
                        <a href="{{ route('articles.create') }}"
                           class="p-4 bg-theme-50 rounded-xl hover:bg-gray-200 transition flex flex-col items-center gap-2 no-underline">
                            <span class="material-icons text-theme-400">add_circle</span>
                            <span class="text-sm font-medium text-theme-700">New Article</span>
                        </a>
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
                                <div class="text-sm text-theme-900">Article "Mindfulness for Beginners" was updated
                                </div>
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
                    <button class="text-theme-400 text-sm font-medium mt-4 hover:text-theme-500 transition">View All
                        Activity
                    </button>
                </div>
            </div>
        </div>
    </div>

    <x-delete-modal
        title="Delete Article"
        message="Are you sure you want to delete this article? This action cannot be undone."
        confirmText="Yes"
        cancelText="No"
        feature="articles"
    />
@endsection

@push('scripts')
    @vite('resources/js/modal-utils.js')
@endpush

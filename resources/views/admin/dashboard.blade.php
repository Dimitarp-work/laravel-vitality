@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="w-full max-w-7xl mx-auto flex flex-col gap-8">
    <!-- Header Section -->
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

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Articles -->
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-theme-100 flex items-center justify-center">
                    <span class="material-icons text-theme-400 text-2xl">article</span>
                </div>
                <span class="text-theme-400 text-sm font-semibold">+12%</span>
            </div>
            <div class="text-2xl font-bold text-theme-900 mb-1">24</div>
            <div class="text-theme-700 text-sm">Total Articles</div>
        </div>

        <!-- Active Users -->
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                    <span class="material-icons text-green-400 text-2xl">group</span>
                </div>
                <span class="text-green-400 text-sm font-semibold">+8%</span>
            </div>
            <div class="text-2xl font-bold text-theme-900 mb-1">1,234</div>
            <div class="text-theme-700 text-sm">Active Users</div>
        </div>

        <!-- Total Views -->
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

        <!-- Engagement Rate -->
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

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Articles Table -->
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
                            <th class="px-4 py-3 text-xs font-semibold text-theme-700 uppercase tracking-wider">Title</th>
                            <th class="px-4 py-3 text-xs font-semibold text-theme-700 uppercase tracking-wider">Author</th>
                            <th class="px-4 py-3 text-xs font-semibold text-theme-700 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-xs font-semibold text-theme-700 uppercase tracking-wider">Date</th>
                            <th class="px-4 py-3 text-xs font-semibold text-theme-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-theme-100">
                        <tr class="hover:bg-theme-50 transition">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-theme-100 flex items-center justify-center">
                                        <span class="material-icons text-theme-400">description</span>
                                    </div>
                                    <div>
                                        <div class="font-medium text-theme-900">How to Stay Motivated</div>
                                        <div class="text-xs text-theme-500">2.5 min read</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-theme-200 flex items-center justify-center text-xs font-medium text-theme-700">JD</div>
                                    <span class="text-theme-700">Jane Doe</span>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Published</span>
                            </td>
                            <td class="px-4 py-3 text-theme-700">2024-05-10</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <button class="p-1 hover:bg-theme-100 rounded transition" title="Edit">
                                        <span class="material-icons text-theme-400 text-base">edit</span>
                                    </button>
                                    <button class="p-1 hover:bg-red-50 rounded transition" title="Delete">
                                        <span class="material-icons text-red-400 text-base">delete</span>
                                    </button>
                                    <button class="p-1 hover:bg-theme-100 rounded transition" title="More">
                                        <span class="material-icons text-theme-400 text-base">more_vert</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-theme-50 transition">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-theme-100 flex items-center justify-center">
                                        <span class="material-icons text-theme-400">description</span>
                                    </div>
                                    <div>
                                        <div class="font-medium text-theme-900">Mindfulness for Beginners</div>
                                        <div class="text-xs text-theme-500">3 min read</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-theme-200 flex items-center justify-center text-xs font-medium text-theme-700">JS</div>
                                    <span class="text-theme-700">John Smith</span>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">Draft</span>
                            </td>
                            <td class="px-4 py-3 text-theme-700">2024-05-09</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <button class="p-1 hover:bg-theme-100 rounded transition" title="Edit">
                                        <span class="material-icons text-theme-400 text-base">edit</span>
                                    </button>
                                    <button class="p-1 hover:bg-red-50 rounded transition" title="Delete">
                                        <span class="material-icons text-red-400 text-base">delete</span>
                                    </button>
                                    <button class="p-1 hover:bg-theme-100 rounded transition" title="More">
                                        <span class="material-icons text-theme-400 text-base">more_vert</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-between mt-6">
                <div class="text-sm text-theme-700">
                    Showing <span class="font-medium">1</span> to <span class="font-medium">2</span> of <span class="font-medium">24</span> results
                </div>
                <div class="flex items-center gap-2">
                    <button class="px-3 py-1 border border-theme-200 rounded-lg text-theme-700 hover:bg-theme-50 transition">Previous</button>
                    <button class="px-3 py-1 bg-theme-400 text-white rounded-lg hover:bg-theme-500 transition">1</button>
                    <button class="px-3 py-1 border border-theme-200 rounded-lg text-theme-700 hover:bg-theme-50 transition">2</button>
                    <button class="px-3 py-1 border border-theme-200 rounded-lg text-theme-700 hover:bg-theme-50 transition">Next</button>
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="flex flex-col gap-6">
            <!-- Quick Actions -->
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

            <!-- Recent Activity -->
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
@endsection

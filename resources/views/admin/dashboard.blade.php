@extends('layouts.vitality')

@section('title', 'Admin Dashboard')

@section('content')
<div class="w-full max-w-6xl mx-auto flex flex-col gap-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-theme-900 mb-1 flex items-center gap-2">
                <span class="material-icons text-theme-400">admin_panel_settings</span>
                Admin Dashboard
            </h1>
            <p class="text-theme-700 text-base">Manage articles and app content</p>
        </div>
        <button class="bg-theme-400 hover:bg-theme-500 text-white rounded-lg px-6 py-2 font-semibold flex items-center gap-2 self-start md:self-auto transition">
            <span class="material-icons text-base">add_circle</span>
            Add Article
        </button>
    </div>
    <div class="bg-white rounded-2xl shadow p-6 overflow-x-auto">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold text-lg text-theme-900 flex items-center gap-2">
                <span class="material-icons text-theme-400">article</span>
                Articles
            </h2>
            <span class="text-theme-700 text-sm">Total: 3</span>
        </div>
        <table class="min-w-full divide-y divide-theme-100 text-left">
            <thead>
                <tr class="bg-theme-50">
                    <th class="px-4 py-2 text-xs font-semibold text-theme-700 uppercase">Title</th>
                    <th class="px-4 py-2 text-xs font-semibold text-theme-700 uppercase">Author</th>
                    <th class="px-4 py-2 text-xs font-semibold text-theme-700 uppercase">Date</th>
                    <th class="px-4 py-2 text-xs font-semibold text-theme-700 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-theme-100">
                <tr>
                    <td class="px-4 py-3 text-theme-900">How to Stay Motivated</td>
                    <td class="px-4 py-3 text-theme-700">Jane Doe</td>
                    <td class="px-4 py-3 text-theme-700">2024-05-10</td>
                    <td class="px-4 py-3">
                        <button class="inline-flex items-center gap-1 text-theme-400 hover:text-theme-500 font-semibold mr-2"><span class="material-icons text-base">edit</span>Edit</button>
                        <button class="inline-flex items-center gap-1 text-red-400 hover:text-red-600 font-semibold"><span class="material-icons text-base">delete</span>Delete</button>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-3 text-theme-900">Mindfulness for Beginners</td>
                    <td class="px-4 py-3 text-theme-700">John Smith</td>
                    <td class="px-4 py-3 text-theme-700">2024-05-09</td>
                    <td class="px-4 py-3">
                        <button class="inline-flex items-center gap-1 text-theme-400 hover:text-theme-500 font-semibold mr-2"><span class="material-icons text-base">edit</span>Edit</button>
                        <button class="inline-flex items-center gap-1 text-red-400 hover:text-red-600 font-semibold"><span class="material-icons text-base">delete</span>Delete</button>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-3 text-theme-900">Healthy Habits for Life</td>
                    <td class="px-4 py-3 text-theme-700">Alice Lee</td>
                    <td class="px-4 py-3 text-theme-700">2024-05-08</td>
                    <td class="px-4 py-3">
                        <button class="inline-flex items-center gap-1 text-theme-400 hover:text-theme-500 font-semibold mr-2"><span class="material-icons text-base">edit</span>Edit</button>
                        <button class="inline-flex items-center gap-1 text-red-400 hover:text-red-600 font-semibold"><span class="material-icons text-base">delete</span>Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="mt-4 text-theme-700 text-xs">* This is a demo. CRUD functionality will be implemented later.</div>
    </div>
</div>
@endsection 
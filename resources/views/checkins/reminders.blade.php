@extends('layouts.vitality')

@section('title', 'Check-in Reminders')

@section('content')
<div class="w-full pl-0 md:pl-72">
    <div class="max-w-5xl mx-auto flex flex-col gap-8 px-6 py-8">
        <!-- Header Card -->
        <div class="w-full bg-gradient-to-r from-pink-200 to-pink-100 rounded-2xl shadow p-6">
            <h1 class="text-2xl font-bold text-pink-900 mb-4 flex items-center gap-2">
                <span class="material-icons text-pink-400">notifications</span>
                Check-in Reminders
            </h1>
            <div class="text-pink-700 font-medium">
                Set up daily notifications for your wellness journey
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="bg-pink-50 rounded-2xl shadow p-1.5 max-w-2xl mx-auto w-full">
            <div class="flex space-x-2">
                <a href="{{ route('checkins.index') }}" class="flex-1 px-4 py-3 text-pink-700 hover:bg-white/50 font-medium rounded-lg transition-all text-center">
                    Today
                </a>
                <a href="{{ route('checkins.week') }}" class="flex-1 px-4 py-3 text-pink-700 hover:bg-white/50 font-medium rounded-lg transition-all text-center">
                    This Week
                </a>
                <a href="{{ route('checkins.reminders') }}" class="flex-1 px-4 py-3 text-pink-900 font-medium rounded-lg bg-white shadow-sm text-center">
                    My Reminders
                </a>
            </div>
        </div>

        <!-- Quick Add Reminder -->
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="max-w-xl mx-auto">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-10 h-10 rounded-lg bg-pink-50 flex items-center justify-center">
                        <span class="material-icons text-pink-500">add_alert</span>
                    </div>
                    <h2 class="text-lg font-bold text-pink-900">Quick Add Reminder</h2>
                </div>

                <form class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-pink-900">Reminder Time</label>
                            <input type="time" class="w-full h-12 px-4 rounded-xl border border-pink-200 focus:ring-2 focus:ring-pink-300 focus:border-pink-300 text-pink-900 appearance-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-pink-900">Category</label>
                            <select class="w-full h-12 px-4 rounded-xl border border-pink-200 focus:ring-2 focus:ring-pink-300 focus:border-pink-300 text-pink-900 appearance-none cursor-pointer">
                                <option>All Categories</option>
                                <option>Movement</option>
                                <option>Hydration</option>
                                <option>Gratitude</option>
                                <option>Mindfulness</option>
                                <option>Stretching</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white rounded-xl px-6 py-2.5 font-semibold transition flex items-center gap-2">
                            <span class="material-icons text-sm">add</span>
                            Add Reminder
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Active Reminders -->
        <div class="bg-white rounded-2xl shadow">
            <div class="p-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-pink-50 flex items-center justify-center">
                        <span class="material-icons text-pink-500">schedule</span>
                    </div>
                    <h2 class="text-lg font-bold text-pink-900">Active Reminders</h2>
                </div>
            </div>

            <!-- Sample Reminders -->
            @foreach([
                ['9:00 AM', 'Movement & Stretching', 'directions_run'],
                ['12:00 PM', 'Hydration Check', 'water_drop'],
                ['3:00 PM', 'Mindfulness Break', 'self_improvement'],
                ['8:00 PM', 'Gratitude Practice', 'favorite']
            ] as [$time, $title, $icon])
                <div class="p-4 flex items-center justify-between hover:bg-pink-50/50 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 rounded-lg bg-pink-100 flex items-center justify-center">
                            <span class="material-icons text-pink-500 text-sm">{{ $icon }}</span>
                        </div>
                        <div>
                            <div class="font-medium text-pink-900">{{ $time }}</div>
                            <div class="text-sm text-pink-600">{{ $title }}</div>
                        </div>
                    </div>
                    <button class="p-2 hover:bg-pink-100 rounded-lg transition-colors">
                        <span class="material-icons text-pink-400 hover:text-pink-600">more_vert</span>
                    </button>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

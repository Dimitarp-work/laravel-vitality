@extends('layouts.vitality')

@section('title', 'Daily Check-ins')

@section('content')
<div class="w-full pl-0 md:pl-72">
    <div class="max-w-5xl mx-auto flex flex-col gap-8 px-6 py-8">
        <!-- Header Card -->
        <div class="w-full bg-gradient-to-r from-pink-200 to-pink-100 rounded-2xl shadow p-6">
            <h1 class="text-2xl font-bold text-pink-900 mb-4 flex items-center gap-2">
                <span class="material-icons text-pink-400">check_circle</span>
                Daily Check-ins
            </h1>
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="text-pink-700 font-medium">
                    {{ now()->format('l, F j, Y') }}
                </div>
                <div class="flex items-center gap-3 bg-white/50 px-5 py-2.5 rounded-xl">
                    <span class="text-pink-700 font-medium">Daily Progress</span>
                    <div class="w-36 h-2 bg-pink-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-pink-500 to-pink-400 rounded-full" style="width: 0%"></div>
                    </div>
                    <span class="text-pink-900 font-medium">0/10</span>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="bg-pink-50 rounded-2xl shadow p-1.5 max-w-2xl mx-auto w-full">
            <div class="flex space-x-2">
                <a href="{{ route('checkins.index') }}" class="flex-1 px-4 py-3 text-pink-900 font-medium rounded-lg bg-white shadow-sm text-center">
                    Today
                </a>
                <a href="{{ route('checkins.week') }}" class="flex-1 px-4 py-3 text-pink-700 hover:bg-white/50 font-medium rounded-lg transition-all text-center">
                    This Week
                </a>
                <a href="{{ route('checkins.reminders') }}" class="flex-1 px-4 py-3 text-pink-700 hover:bg-white/50 font-medium rounded-lg transition-all text-center">
                    My Reminders
                </a>
            </div>
        </div>

        <!-- Check-ins Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Self-care Moments -->
            <div class="bg-white rounded-2xl shadow p-6">
                <div class="font-bold text-pink-900 mb-4 text-lg flex items-center gap-2">
                    <span class="material-icons text-pink-400">favorite</span>
                    Self-care Moments
                    <span class="ml-2 text-xs bg-pink-100 text-pink-700 rounded-full px-3 py-0.5">5 tasks</span>
                </div>
                <div class="space-y-4">
                    <label class="group flex items-center justify-between p-4 bg-pink-50 rounded-xl hover:bg-pink-100/50 transition-all cursor-pointer">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">💧</span>
                            <span class="text-pink-900">Drink enough water today?</span>
                        </div>
                        <input type="checkbox" class="w-6 h-6 rounded-full accent-pink-400">
                    </label>

                    <label class="group flex items-center justify-between p-4 bg-pink-50 rounded-xl hover:bg-pink-100/50 transition-all cursor-pointer">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">🧘‍♀️</span>
                            <span class="text-pink-900">Take a moment to stretch?</span>
                        </div>
                        <input type="checkbox" class="w-6 h-6 rounded-full accent-pink-400">
                    </label>

                    <label class="group flex items-center justify-between p-4 bg-pink-50 rounded-xl hover:bg-pink-100/50 transition-all cursor-pointer">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">🍽️</span>
                            <span class="text-pink-900">Eat regular meals today?</span>
                        </div>
                        <input type="checkbox" class="w-6 h-6 rounded-full accent-pink-400">
                    </label>

                    <label class="group flex items-center justify-between p-4 bg-pink-50 rounded-xl hover:bg-pink-100/50 transition-all cursor-pointer">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">😴</span>
                            <span class="text-pink-900">Get enough sleep last night?</span>
                        </div>
                        <input type="checkbox" class="w-6 h-6 rounded-full accent-pink-400">
                    </label>

                    <label class="group flex items-center justify-between p-4 bg-pink-50 rounded-xl hover:bg-pink-100/50 transition-all cursor-pointer">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">💊</span>
                            <span class="text-pink-900">Take medications/vitamins?</span>
                        </div>
                        <input type="checkbox" class="w-6 h-6 rounded-full accent-pink-400">
                    </label>
                </div>
            </div>

            <!-- Mindfulness Check -->
            <div class="bg-white rounded-2xl shadow p-6">
                <div class="font-bold text-pink-900 mb-4 text-lg flex items-center gap-2">
                    <span class="material-icons text-pink-400">self_improvement</span>
                    Mindfulness Check
                    <span class="ml-2 text-xs bg-pink-100 text-pink-700 rounded-full px-3 py-0.5">5 tasks</span>
                </div>
                <div class="space-y-4">
                    <label class="group flex items-center justify-between p-4 bg-pink-50 rounded-xl hover:bg-pink-100/50 transition-all cursor-pointer">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">📱</span>
                            <span class="text-pink-900">Take time off screens today?</span>
                        </div>
                        <input type="checkbox" class="w-6 h-6 rounded-full accent-pink-400">
                    </label>

                    <label class="group flex items-center justify-between p-4 bg-pink-50 rounded-xl hover:bg-pink-100/50 transition-all cursor-pointer">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">🫁</span>
                            <span class="text-pink-900">Practice deep breathing?</span>
                        </div>
                        <input type="checkbox" class="w-6 h-6 rounded-full accent-pink-400">
                    </label>

                    <label class="group flex items-center justify-between p-4 bg-pink-50 rounded-xl hover:bg-pink-100/50 transition-all cursor-pointer">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">🌿</span>
                            <span class="text-pink-900">Spend time in nature today?</span>
                        </div>
                        <input type="checkbox" class="w-6 h-6 rounded-full accent-pink-400">
                    </label>

                    <label class="group flex items-center justify-between p-4 bg-pink-50 rounded-xl hover:bg-pink-100/50 transition-all cursor-pointer">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">🤔</span>
                            <span class="text-pink-900">Take a moment for self-reflection?</span>
                        </div>
                        <input type="checkbox" class="w-6 h-6 rounded-full accent-pink-400">
                    </label>

                    <label class="group flex items-center justify-between p-4 bg-pink-50 rounded-xl hover:bg-pink-100/50 transition-all cursor-pointer">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">🙏</span>
                            <span class="text-pink-900">Practice gratitude today?</span>
                        </div>
                        <input type="checkbox" class="w-6 h-6 rounded-full accent-pink-400">
                    </label>
                </div>
            </div>
        </div>

        <!-- Add Custom Check-in -->
        <div class="bg-pink-50 rounded-2xl shadow p-6">
            <div class="font-bold text-pink-900 mb-4 text-lg flex items-center gap-2">
                <span class="material-icons text-pink-400">add_circle</span>
                Create Custom Check-in
            </div>
            <div class="flex gap-3">
                <input type="text"
                    placeholder="Type your custom check-in here..."
                    class="flex-1 px-4 py-2.5 rounded-lg border border-pink-200 focus:ring-2 focus:ring-pink-300 text-sm"
                >
                <button class="bg-pink-400 hover:bg-pink-500 text-white rounded-lg px-5 py-1.5 font-semibold w-24 transition text-sm self-start">
                    Add
                </button>
            </div>
        </div>
    </div>
</div>
@endsection


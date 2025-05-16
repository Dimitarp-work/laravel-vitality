@extends('layouts.vitality')

@section('title', 'Home')

@section('content')
<div class="w-full max-w-6xl mx-auto flex flex-col gap-8">
    <!-- User summary card -->
    <div class="w-full bg-gradient-to-r from-pink-200 to-pink-100 rounded-2xl shadow p-6 flex flex-col md:flex-row items-center gap-6">
        <div class="flex items-center gap-4 flex-1">
            <div class="w-16 h-16 rounded-full bg-pink-300 flex items-center justify-center text-3xl font-bold text-white">JD</div>
            <div>
                <div class="font-semibold text-xl text-pink-900">John Doe <span class="ml-2 text-xs bg-pink-200 text-pink-700 rounded px-2 py-0.5">Wellness Seeker</span></div>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-xs bg-pink-300 text-white rounded px-2 py-0.5">Level 5</span>
                    <span class="text-xs text-pink-700">450 / 500 XP</span>
                </div>
                <div class="w-40 h-2 bg-pink-100 rounded-full overflow-hidden mt-2">
                    <div class="h-full bg-pink-400 rounded-full" style="width: 90%"></div>
                </div>
            </div>
        </div>
        <div class="flex flex-col items-end">
            <span class="text-xs text-pink-700 font-semibold flex items-center gap-1"><span class="material-icons text-pink-400 text-base">monetization_on</span> 450 Credits</span>
        </div>
    </div>
    <!-- Main grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="flex flex-col gap-8">
            <!-- How are you feeling? -->
            <div class="bg-white rounded-2xl shadow p-6 flex flex-col items-center">
                <div class="font-bold text-pink-900 mb-2 text-lg flex items-center gap-2"><span class="material-icons text-pink-400">mood</span>How are you feeling?</div>
                <div class="flex gap-3 text-3xl mb-2">
                    <span>😊</span><span>😌</span><span>😐</span><span>😣</span><span>😢</span>
                </div>
                <div class="flex gap-3 text-xs text-gray-500">
                    <span>Happy</span><span>Calm</span><span>Neutral</span><span>Stressed</span><span>Sad</span>
                </div>
            </div>
            <!-- Wellness Inspiration -->
            <div class="bg-pink-50 rounded-2xl shadow p-6 flex flex-col">
                <div class="font-bold text-pink-900 mb-3 flex items-center gap-2"><span class="material-icons text-pink-400">lightbulb</span>Wellness Inspiration</div>
                <div class="space-y-2">
                    <div class="bg-white rounded-lg p-3 flex flex-col shadow-sm">
                        <span class="font-semibold text-pink-900">Gentle Stretches for Better Sleep</span>
                        <span class="text-xs text-pink-600">5 min read</span>
                    </div>
                    <div class="bg-white rounded-lg p-3 flex flex-col shadow-sm">
                        <span class="font-semibold text-pink-900">Finding Calm in Daily Moments</span>
                        <span class="text-xs text-pink-600">3 min read</span>
                    </div>
                </div>
                <button class="bg-pink-100 text-pink-700 rounded-lg px-4 py-1 mt-4 font-semibold w-fit hover:bg-pink-200 transition text-sm self-start" aria-label="Explore articles">Explore Articles</button>
            </div>
            <!-- Customization Store -->
            <div class="bg-white rounded-2xl shadow p-6 flex flex-col">
                <div class="font-bold text-pink-900 mb-2 flex items-center gap-2"><span class="material-icons text-pink-400">store</span>Customization Store</div>
                <span class="text-pink-700 font-extrabold text-lg">450 Credits</span>
                <span class="text-xs text-pink-700 mb-2">Use your credits to customize your profile</span>
                <button class="bg-pink-100 text-pink-700 rounded-lg px-4 py-1 mt-2 font-semibold w-fit hover:bg-pink-200 transition text-sm self-start" aria-label="Visit store">Visit Store</button>
            </div>
        </div>
        <div class="flex flex-col gap-8">
            <!-- A thought to capture? -->
            <div class="bg-white rounded-2xl shadow p-6 flex flex-col">
                <div class="font-bold text-pink-900 mb-2 text-lg flex items-center gap-2"><span class="material-icons text-pink-400">edit</span>A thought to capture?</div>
                <textarea class="border border-pink-200 rounded-lg p-2 mb-3 resize-none focus:ring-2 focus:ring-pink-300 text-sm" rows="2" placeholder="Write anything that comes to mind..."></textarea>
                <button class="bg-pink-400 hover:bg-pink-500 text-white rounded-lg px-5 py-1.5 font-semibold w-24 ml-auto transition text-sm" aria-label="Save thought">Save</button>
            </div>
            <!-- Gentle Reminders -->
            <div class="bg-white rounded-2xl shadow p-6 flex flex-col">
                <div class="font-bold text-pink-900 mb-2 text-lg flex items-center gap-2"><span class="material-icons text-pink-400">notifications_active</span>Gentle Reminders</div>
                <ul class="text-pink-700 text-base space-y-1 mb-2">
                    <li class="flex items-center gap-2"><span class="material-icons text-pink-300 text-base">check</span>Did you take a moment for yourself today?</li>
                    <li class="flex items-center gap-2"><span class="material-icons text-pink-300 text-base">water_drop</span>Have you had enough water today?</li>
                    <li class="flex items-center gap-2"><span class="material-icons text-pink-300 text-base">directions_run</span>Have you moved your body a little?</li>
                    <li class="flex items-center gap-2"><span class="material-icons text-pink-300 text-base">park</span>Connected with nature today?</li>
                </ul>
                <button class="text-pink-500 text-xs font-semibold ml-auto hover:underline" aria-label="View more reminders">View More</button>
            </div>
            <!-- Your Wellness Journey -->
            <div class="bg-pink-50 rounded-2xl shadow p-6 flex flex-col">
                <div class="font-bold text-pink-900 mb-2 flex items-center gap-2"><span class="material-icons text-pink-400">directions_walk</span>Your Wellness Journey</div>
                <ul class="space-y-2">
                    <li class="bg-white rounded-lg px-3 py-2 flex items-center gap-2 text-pink-700 font-medium shadow-sm"><span class="material-icons text-pink-400">water_drop</span> Stay hydrated throughout the day</li>
                    <li class="bg-white rounded-lg px-3 py-2 flex items-center gap-2 text-pink-700 font-medium shadow-sm"><span class="material-icons text-pink-400">directions_run</span> Move your body when you can</li>
                    <li class="bg-white rounded-lg px-3 py-2 flex items-center gap-2 text-pink-700 font-medium shadow-sm"><span class="material-icons text-pink-400">air</span> Take moments to breathe</li>
                </ul>
                <button class="text-pink-500 text-xs font-semibold ml-auto mt-2 hover:underline" aria-label="View journey">View Journey</button>
            </div>
            <!-- Recent Badges -->
            <div class="bg-white rounded-2xl shadow p-6 flex flex-col">
                <div class="font-bold text-pink-900 mb-2 flex items-center gap-2"><span class="material-icons text-pink-400">stars</span>Recent Badges</div>
                <div class="flex gap-2 mb-2 flex-wrap">
                    <span class="bg-pink-200 text-pink-800 rounded-full px-4 py-1 text-xs font-semibold flex items-center gap-1"><span class="material-icons text-pink-400 text-base">water_drop</span>Hydration Champion</span>
                    <span class="bg-pink-200 text-pink-800 rounded-full px-4 py-1 text-xs font-semibold flex items-center gap-1"><span class="material-icons text-pink-400 text-base">devices</span>Digital Balance</span>
                    <span class="bg-pink-200 text-pink-800 rounded-full px-4 py-1 text-xs font-semibold flex items-center gap-1"><span class="material-icons text-pink-400 text-base">favorite</span>Gratitude Guide</span>
                </div>
                <button class="text-pink-500 text-xs font-semibold ml-auto hover:underline" aria-label="View all badges">View All Badges</button>
            </div>
        </div>
    </div>
    <!-- Your Week in Feelings -->
    <div class="bg-gradient-to-r from-pink-200 to-pink-100 rounded-2xl shadow p-8 w-full mt-2">
        <div class="font-bold text-pink-900 mb-3 text-lg flex items-center gap-2"><span class="material-icons text-pink-400">calendar_month</span>Your Week in Feelings</div>
        <div class="flex gap-6 mb-2 overflow-x-auto">
            <div class="flex flex-col items-center min-w-[40px]"><span class="text-3xl">😊</span><span class="text-xs mt-1">Mon</span></div>
            <div class="flex flex-col items-center min-w-[40px]"><span class="text-3xl">😊</span><span class="text-xs mt-1">Tue</span></div>
            <div class="flex flex-col items-center min-w-[40px]"><span class="text-3xl">😊</span><span class="text-xs mt-1">Wed</span></div>
            <div class="flex flex-col items-center min-w-[40px]"><span class="text-3xl">😊</span><span class="text-xs mt-1">Thu</span></div>
            <div class="flex flex-col items-center min-w-[40px]"><span class="text-3xl text-gray-400">?</span><span class="text-xs mt-1">Fri</span></div>
            <div class="flex flex-col items-center min-w-[40px]"><span class="text-3xl text-gray-400">?</span><span class="text-xs mt-1">Sat</span></div>
            <div class="flex flex-col items-center min-w-[40px]"><span class="text-3xl text-gray-400">?</span><span class="text-xs mt-1">Sun</span></div>
        </div>
        <div class="text-xs md:text-sm text-pink-700">You've had some lovely moments this week. Each day is a new opportunity.</div>
    </div>
</div>
@endsection

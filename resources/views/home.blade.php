@extends('layouts.vitality')

@section('title', 'Home')

@section('content')
<div class="flex flex-col gap-6">
    <div>
        <h1 class="text-2xl font-bold text-pink-900 mb-1">Good evening, John! <span class="inline-block">👋</span></h1>
        <p class="text-gray-500">How are you feeling today?</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- How are you feeling? -->
        <div class="bg-white rounded-xl shadow p-5 flex flex-col items-center">
            <div class="font-semibold text-pink-900 mb-2">How are you feeling?</div>
            <div class="flex gap-2 text-2xl">
                <span>😊</span><span>😌</span><span>😐</span><span>😣</span><span>😢</span>
            </div>
        </div>
        <!-- A thought to capture? -->
        <div class="bg-white rounded-xl shadow p-5 flex flex-col">
            <div class="font-semibold text-pink-900 mb-2">A thought to capture?</div>
            <textarea class="border rounded p-2 mb-2 resize-none" rows="2" placeholder="Write anything that comes to mind..."></textarea>
            <button class="bg-pink-400 text-white rounded px-4 py-1 self-end">Save</button>
        </div>
        <!-- Gentle Reminders -->
        <div class="bg-white rounded-xl shadow p-5 flex flex-col">
            <div class="font-semibold text-pink-900 mb-2">Gentle Reminders</div>
            <ul class="text-sm text-pink-800 space-y-1">
                <li>• Did you take a moment for yourself today?</li>
                <li>• Have you had enough water today?</li>
                <li>• Have you moved your body a little?</li>
                <li>• Connected with nature today?</li>
            </ul>
            <button class="text-pink-500 text-xs mt-2 self-end">View More</button>
        </div>
        <!-- Empty for spacing -->
        <div></div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Wellness Inspiration -->
        <div class="bg-white rounded-xl shadow p-5 flex flex-col">
            <div class="font-semibold text-pink-900 mb-2">Wellness Inspiration</div>
            <div class="space-y-2">
                <div class="bg-pink-50 rounded p-2 flex flex-col">
                    <span class="font-medium">Gentle Stretches for Better Sleep</span>
                    <span class="text-xs text-pink-700">5 min read</span>
                </div>
                <div class="bg-pink-50 rounded p-2 flex flex-col">
                    <span class="font-medium">Finding Calm in Daily Moments</span>
                    <span class="text-xs text-pink-700">3 min read</span>
                </div>
            </div>
            <button class="bg-pink-100 text-pink-700 rounded px-3 py-1 mt-3 self-start">Explore Articles</button>
        </div>
        <!-- Your Wellness Journey -->
        <div class="bg-white rounded-xl shadow p-5 flex flex-col">
            <div class="font-semibold text-pink-900 mb-2">Your Wellness Journey</div>
            <ul class="space-y-2">
                <li class="bg-pink-50 rounded px-3 py-2 flex items-center gap-2"><span class="material-icons text-pink-400">water_drop</span> Stay hydrated throughout the day</li>
                <li class="bg-pink-50 rounded px-3 py-2 flex items-center gap-2"><span class="material-icons text-pink-400">directions_run</span> Move your body when you can</li>
                <li class="bg-pink-50 rounded px-3 py-2 flex items-center gap-2"><span class="material-icons text-pink-400">air</span> Take moments to breathe</li>
            </ul>
            <button class="text-pink-500 text-xs mt-2 self-end">View Journey</button>
        </div>
        <!-- Customization Store & Badges -->
        <div class="flex flex-col gap-6">
            <div class="bg-white rounded-xl shadow p-5 flex flex-col">
                <div class="font-semibold text-pink-900 mb-2">Customization Store</div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-pink-700 font-bold text-lg">450 Credits</span>
                </div>
                <span class="text-xs text-pink-700 mb-2">Use your credits to customize your profile</span>
                <button class="bg-pink-100 text-pink-700 rounded px-3 py-1 self-start">Visit Store</button>
            </div>
            <div class="bg-white rounded-xl shadow p-5 flex flex-col">
                <div class="font-semibold text-pink-900 mb-2">Recent Badges</div>
                <div class="flex gap-2 mb-2">
                    <span class="bg-pink-200 text-pink-800 rounded-full px-3 py-1 text-xs">Hydration Champion</span>
                    <span class="bg-pink-200 text-pink-800 rounded-full px-3 py-1 text-xs">Digital Balance</span>
                    <span class="bg-pink-200 text-pink-800 rounded-full px-3 py-1 text-xs">Gratitude Guide</span>
                </div>
                <button class="text-pink-500 text-xs self-end">View All Badges</button>
            </div>
        </div>
    </div>
    <!-- Your Week in Feelings -->
    <div class="bg-gradient-to-r from-pink-200 to-pink-100 rounded-xl shadow p-6 mt-4">
        <div class="font-semibold text-pink-900 mb-2">Your Week in Feelings</div>
        <div class="flex gap-4">
            <div class="flex flex-col items-center"><span class="text-2xl">😊</span><span class="text-xs mt-1">Mon</span></div>
            <div class="flex flex-col items-center"><span class="text-2xl">😊</span><span class="text-xs mt-1">Tue</span></div>
            <div class="flex flex-col items-center"><span class="text-2xl">😊</span><span class="text-xs mt-1">Wed</span></div>
            <div class="flex flex-col items-center"><span class="text-2xl">😊</span><span class="text-xs mt-1">Thu</span></div>
            <div class="flex flex-col items-center"><span class="text-2xl text-gray-400">?</span><span class="text-xs mt-1">Fri</span></div>
            <div class="flex flex-col items-center"><span class="text-2xl text-gray-400">?</span><span class="text-xs mt-1">Sat</span></div>
            <div class="flex flex-col items-center"><span class="text-2xl text-gray-400">?</span><span class="text-xs mt-1">Sun</span></div>
        </div>
        <div class="text-xs text-pink-700 mt-2">You've had some lovely moments this week. Each day is a new opportunity.</div>
    </div>
</div>
@endsection 
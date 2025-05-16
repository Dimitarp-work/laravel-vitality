@extends('layouts.vitality')

@section('title', 'Weekly Check-ins')

@section('content')
<div class="w-full pl-0 md:pl-72">
    <div class="max-w-5xl mx-auto flex flex-col gap-8 px-6 py-8">
        <!-- Header Card -->
        <div class="w-full bg-gradient-to-r from-pink-200 to-pink-100 rounded-2xl shadow p-6">
            <h1 class="text-2xl font-bold text-pink-900 mb-4 flex items-center gap-2">
                <span class="material-icons text-pink-400">calendar_today</span>
                Weekly Check-ins
            </h1>
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="text-pink-700 font-medium">
                    Week of {{ now()->startOfWeek()->format('F j') }} - {{ now()->endOfWeek()->format('F j, Y') }}
                </div>
                <div class="flex items-center gap-3 bg-white/50 px-5 py-2.5 rounded-xl">
                    <span class="text-pink-700 font-medium">Weekly Progress</span>
                    <div class="w-36 h-2 bg-pink-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-pink-500 to-pink-400 rounded-full" style="width: 34%"></div>
                    </div>
                    <span class="text-pink-900 font-medium">12/35</span>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="bg-pink-50 rounded-2xl shadow p-1.5 max-w-2xl mx-auto w-full">
            <div class="flex space-x-2">
                <a href="{{ route('checkins.index') }}" class="flex-1 px-4 py-3 text-pink-700 hover:bg-white/50 font-medium rounded-lg transition-all text-center">
                    Today
                </a>
                <a href="{{ route('checkins.week') }}" class="flex-1 px-4 py-3 text-pink-900 font-medium rounded-lg bg-white shadow-sm text-center">
                    This Week
                </a>
                <a href="{{ route('checkins.reminders') }}" class="flex-1 px-4 py-3 text-pink-700 hover:bg-white/50 font-medium rounded-lg transition-all text-center">
                    My Reminders
                </a>
            </div>
        </div>

        <!-- Weekly Stamp Card -->
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="overflow-x-auto">
                <table class="w-full border-none border-collapse [&_*]:border-0">
                    <thead>
                        <tr class="border-0">
                            <th class="px-4 py-3 text-left text-pink-900 font-semibold">Category</th>
                            @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                                <th class="px-4 py-3 text-center text-pink-700 font-medium">
                                    <div>{{ $day }}</div>
                                    <div class="text-xs text-pink-400">{{ now()->startOfWeek()->addDays($loop->index)->format('j') }}</div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach([
                            ['Movement', 'directions_run'],
                            ['Hydration', 'water_drop'],
                            ['Gratitude', 'favorite'],
                            ['Mindfulness', 'self_improvement'],
                            ['Stretching', 'sports_gymnastics']
                        ] as [$category, $icon])
                            <tr class="hover:bg-pink-50/50 transition-colors border-0">
                                <td class="px-4 py-4 text-pink-900 font-medium flex items-center gap-2">
                                    <span class="material-icons text-pink-400">{{ $icon }}</span>
                                    {{ $category }}
                                </td>
                                @foreach(range(1, 7) as $day)
                                    <td class="px-4 py-4">
                                        <div class="w-10 h-10 mx-auto rounded-full border-2 border-pink-200 flex items-center justify-center hover:border-pink-300 hover:bg-pink-50 transition-all cursor-pointer">
                                            <span class="material-icons text-pink-400 text-xl">radio_button_unchecked</span>
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Weekly Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach([
                ['Total Check-ins', '12/35', 'check_circle'],
                ['Best Category', 'Hydration', 'water_drop'],
                ['Current Streak', '3 days', 'local_fire_department'],
                ['Weekly Goal', '34%', 'track_changes']
            ] as [$title, $value, $icon])
                <div class="bg-white rounded-xl shadow p-4">
                    <div class="flex items-center gap-3">
                        <span class="material-icons text-pink-400">{{ $icon }}</span>
                        <div>
                            <div class="text-sm text-pink-700">{{ $title }}</div>
                            <div class="text-lg font-semibold text-pink-900">{{ $value }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

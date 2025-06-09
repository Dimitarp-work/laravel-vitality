@extends('layouts.vitality')

@section('title', 'Settings')

@section('content')
<div class="w-full pl-0 md:pl-72">
    <div class="max-w-4xl mx-auto px-6 py-8">
        <h1 class="text-2xl font-bold text-pink-900 mb-6">Settings</h1>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-xl font-bold text-pink-700 mb-4">Notification Settings</h2>

            <form action="{{ route('settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Enable Notifications -->
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="text-gray-700 font-medium">Enable Notifications</label>
                            <p class="text-sm text-gray-500">Receive reminders for your goals, challenges, and daily check-ins</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="is_enabled" value="0">
                            <input type="checkbox" name="is_enabled" value="1" class="sr-only peer" {{ $settings->is_enabled ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-pink-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-pink-600"></div>
                        </label>
                    </div>

                    <!-- Reminder Interval -->
                    <div>
                        <label for="reminder_interval" class="block text-gray-700 font-medium mb-2">Reminder Interval</label>
                        <div class="flex items-center gap-4">
                            <input type="range" id="reminder_interval" name="reminder_interval"
                                   min="15" max="1440" step="15" value="{{ $settings->reminder_interval }}"
                                   class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                            <span id="interval_display" class="text-pink-600 font-medium min-w-[100px]">
                                {{ floor($settings->reminder_interval / 60) }}h {{ $settings->reminder_interval % 60 }}m
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">How often you want to receive reminders (between 15 minutes and 24 hours)</p>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-2 rounded-lg font-medium">
                            Save Settings
                        </button>
                    </div>
                </div>
            </form>

            <!-- Test Reminders Button -->
            <div class="mt-8 pt-8 border-t">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Test Notifications</h3>
                <p class="text-sm text-gray-500 mb-4">Click the button below to test how your reminders will appear in notifications.</p>
                <form action="{{ route('settings.test-reminders') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium flex items-center gap-2">
                        <span class="material-icons text-base">notifications</span>
                        Test Reminders
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const intervalInput = document.getElementById('reminder_interval');
    const intervalDisplay = document.getElementById('interval_display');

    intervalInput.addEventListener('input', function() {
        const minutes = parseInt(this.value);
        const hours = Math.floor(minutes / 60);
        const remainingMinutes = minutes % 60;
        intervalDisplay.textContent = `${hours}h ${remainingMinutes}m`;
    });
</script>
@endsection

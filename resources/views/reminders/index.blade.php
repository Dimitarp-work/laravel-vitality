@extends('layouts.vitality')

@section('title', 'Reminders')

@push('scripts')
    @vite(['resources/js/modal-utils.js', 'resources/js/reminders_modals.js'])
@endpush

@section('content')
<div class="w-full pl-0 md:pl-72">
    <div class="max-w-5xl mx-auto flex flex-col gap-8 px-6 py-8">
        <h1 class="text-2xl font-bold text-pink-900 mb-6">My Personal Reminders</h1>

        <!-- Overall Reminders Progress -->
        <div class="w-full bg-gradient-to-r from-pink-200 to-pink-100 rounded-2xl shadow p-4 flex items-center justify-between">
            <span class="text-pink-900 font-bold text-lg">Reminders Progress</span>
            <span class="text-pink-700 font-medium">Completed {{ $completedRemindersCount }} / {{ $totalRemindersCount }} Reminders</span>
        </div>

        <!-- Filter Buttons -->
        <div class="bg-pink-50 rounded-2xl shadow p-1.5 max-w-2xl mx-auto w-full">
            <div class="flex space-x-2">
                <a href="{{ route('reminders.index', ['type' => null]) }}" class="flex-1 px-4 py-3 text-pink-700 hover:bg-white/50 font-medium rounded-lg transition-all text-center {{ request()->query('type') === null ? 'bg-white shadow-sm text-pink-900' : '' }}">
                    All Reminders
                </a>
                <a href="{{ route('reminders.index', ['type' => 'challenge']) }}" class="flex-1 px-4 py-3 text-pink-700 hover:bg-white/50 font-medium rounded-lg transition-all text-center {{ request()->query('type') === 'challenge' ? 'bg-white shadow-sm text-pink-900' : '' }}">
                    Challenges
                </a>
                <a href="{{ route('reminders.index', ['type' => 'goal']) }}" class="flex-1 px-4 py-3 text-pink-700 hover:bg-white/50 font-medium rounded-lg transition-all text-center {{ request()->query('type') === 'goal' ? 'bg-white shadow-sm text-pink-900' : '' }}">
                    Goals
                </a>
                <a href="{{ route('reminders.index', ['type' => 'daily_checkin']) }}" class="flex-1 px-4 py-3 text-pink-700 hover:bg-white/50 font-medium rounded-lg transition-all text-center {{ request()->query('type') === 'daily_checkin' ? 'bg-white shadow-sm text-pink-900' : '' }}">
                    Daily Check-ins
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 space-y-4">
            @if($type === null)
                @forelse($groupedReminders as $typeKey => $remindersGroup)
                    <h2 class="text-xl font-bold text-pink-700 mt-6 mb-3 flex items-center gap-2">
                        <span>{{ ucfirst(str_replace('_', ' ', $typeKey)) }} Reminders</span>
                        @if(isset($typeCounts[$typeKey]))
                            <span class="text-sm bg-pink-100 text-pink-700 rounded-full px-3 py-0.5">
                                {{ $typeCounts[$typeKey]['completed'] }} / {{ $typeCounts[$typeKey]['total'] }}
                            </span>
                        @endif
                    </h2>
                    @foreach($remindersGroup as $reminder)
                        <div class="flex items-center justify-between rounded-lg p-4 {{ $reminder->is_completed ? 'bg-green-50 opacity-70' : 'bg-gray-50' }}">
                            <div class="flex items-center gap-4">
                                @php
                                    $icon = 'notifications'; // Default icon
                                    $title = 'Unknown Reminder';
                                    $description = 'N/A';

                                    if ($reminder->relatedEntity) {
                                        switch ($reminder->type) {
                                            case 'goal':
                                                $icon = 'flag';
                                                $title = $reminder->relatedEntity->title;
                                                $description = $reminder->relatedEntity->description;
                                                break;
                                            case 'challenge':
                                                $icon = 'emoji_events';
                                                $title = $reminder->relatedEntity->title;
                                                $description = $reminder->relatedEntity->description;
                                                break;
                                            case 'daily_checkin':
                                                $icon = 'check_circle';
                                                $title = $reminder->relatedEntity->title;
                                                $description = 'Daily Check-in';
                                                break;
                                        }
                                    }
                                @endphp
                                <span class="material-icons text-3xl text-pink-500">{{ $icon }}</span>
                                <div>
                                    <div class="font-medium text-gray-900">{{ $title }}</div>
                                    <div class="text-sm text-gray-600">{{ $description }}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button onclick="openDeleteModal('{{ $reminder->id }}')"
                                        class="w-8 h-8 flex items-center justify-center rounded-full bg-red-100 text-red-700 hover:bg-red-200 transition duration-150"
                                        title="Remove Reminder">
                                    <span class="material-icons text-base">delete</span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @empty
                    <p class="text-center text-gray-500">No reminders found.</p>
                @endforelse
            @else
                <!-- Display count for filtered category -->
                @if(isset($typeCounts[$type]))
                    <h2 class="text-xl font-bold text-pink-700 mt-6 mb-3 flex items-center gap-2">
                        <span>{{ ucfirst(str_replace('_', ' ', $type)) }} Reminders</span>
                        <span class="text-sm bg-pink-100 text-pink-700 rounded-full px-3 py-0.5">
                            {{ $typeCounts[$type]['completed'] }} / {{ $typeCounts[$type]['total'] }}
                        </span>
                    </h2>
                @endif
                @forelse($reminders as $reminder)
                    <div class="flex items-center justify-between rounded-lg p-4 {{ $reminder->is_completed ? 'bg-green-50 opacity-70' : 'bg-gray-50' }}">
                        <div class="flex items-center gap-4">
                            @php
                                $icon = 'notifications'; // Default icon
                                $title = 'Unknown Reminder';
                                $description = 'N/A';

                                if ($reminder->relatedEntity) {
                                    switch ($reminder->type) {
                                        case 'goal':
                                            $icon = 'flag';
                                            $title = $reminder->relatedEntity->title;
                                            $description = $reminder->relatedEntity->description;
                                            break;
                                        case 'challenge':
                                            $icon = 'emoji_events';
                                            $title = $reminder->relatedEntity->title;
                                            $description = $reminder->relatedEntity->description;
                                            break;
                                        case 'daily_checkin':
                                            $icon = 'check_circle';
                                            $title = $reminder->relatedEntity->title;
                                            $description = 'Daily Check-in';
                                            break;
                                    }
                                }
                            @endphp
                            <span class="material-icons text-3xl text-pink-500">{{ $icon }}</span>
                            <div>
                                <div class="font-medium text-gray-900">{{ $title }}</div>
                                <div class="text-sm text-gray-600">{{ $description }}</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="openDeleteModal('{{ $reminder->id }}')"
                                    class="w-8 h-8 flex items-center justify-center rounded-full bg-red-100 text-red-700 hover:bg-red-200 transition duration-150"
                                    title="Remove Reminder">
                                <span class="material-icons text-base">delete</span>
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500">No reminders found for this category.</p>
                @endforelse
            @endif

            <!-- Add New Reminder Button -->
            <a href="{{ route('reminders.create') }}" class="w-full border-2 border-dashed border-gray-300 rounded-lg py-4 text-gray-500 font-medium flex items-center justify-center gap-2 hover:bg-gray-50 transition">
                <span class="material-icons text-xl">add</span>
                Add New Reminder
            </a>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 transition-opacity duration-300 opacity-0">
        <div class="bg-white rounded-xl shadow-md p-6 max-w-sm w-full transform transition-transform duration-300 scale-95">
            <h3 class="text-lg font-medium mb-4">Confirm Deletion</h3>
            <p class="text-gray-600 mb-6">Are you sure you want to delete this reminder? This action cannot be undone.</p>
            <div class="flex justify-end gap-2">
                <button onclick="closeDeleteModal()"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">
                    Cancel
                </button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                        Delete Reminder
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal(reminderId) {
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `/reminders/${reminderId}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }
    </script>
</div>
@endsection

@extends('layouts.vitality')

@section('title', 'Reminders')

@push('scripts')
    @vite(['resources/js/modal-utils.js', 'resources/js/reminders_modals.js'])
@endpush

@section('content')
<div class="w-full pl-0 md:pl-72">
    <div class="max-w-5xl mx-auto flex flex-col gap-4 md:gap-8 px-4 md:px-6 py-6 md:py-8">
        <h1 class="text-xl md:text-2xl font-bold text-pink-900 mb-4 md:mb-6">My Personal Reminders</h1>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 md:p-4 rounded">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Filter Buttons -->
        <div class="bg-pink-50 rounded-2xl shadow p-1 md:p-1.5 max-w-2xl mx-auto w-full overflow-x-auto">
            <div class="flex space-x-1 md:space-x-2 min-w-max">
                <a href="{{ route('reminders.index', ['type' => null]) }}" class="flex-1 px-3 md:px-4 py-2 md:py-3 text-pink-700 hover:bg-white/50 font-medium rounded-lg transition-all text-center text-sm md:text-base {{ request()->query('type') === null ? 'bg-white shadow-sm text-pink-900' : '' }}">
                    All Reminders
                </a>
                <a href="{{ route('reminders.index', ['type' => 'challenge']) }}" class="flex-1 px-3 md:px-4 py-2 md:py-3 text-pink-700 hover:bg-white/50 font-medium rounded-lg transition-all text-center text-sm md:text-base {{ request()->query('type') === 'challenge' ? 'bg-white shadow-sm text-pink-900' : '' }}">
                    Challenges
                </a>
                <a href="{{ route('reminders.index', ['type' => 'goal']) }}" class="flex-1 px-3 md:px-4 py-2 md:py-3 text-pink-700 hover:bg-white/50 font-medium rounded-lg transition-all text-center text-sm md:text-base {{ request()->query('type') === 'goal' ? 'bg-white shadow-sm text-pink-900' : '' }}">
                    Goals
                </a>
                <a href="{{ route('reminders.index', ['type' => 'daily_checkin']) }}" class="flex-1 px-3 md:px-4 py-2 md:py-3 text-pink-700 hover:bg-white/50 font-medium rounded-lg transition-all text-center text-sm md:text-base {{ request()->query('type') === 'daily_checkin' ? 'bg-white shadow-sm text-pink-900' : '' }}">
                    Daily Check-ins
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-4 md:p-6 space-y-3 md:space-y-4">
            @if($type === null)
                @forelse($groupedReminders as $typeKey => $remindersGroup)
                    <h2 class="text-lg md:text-xl font-bold text-pink-700 mt-4 md:mt-6 mb-2 md:mb-3 flex items-center gap-2">
                        <span>{{ ucfirst(str_replace('_', ' ', $typeKey)) }} Reminders</span>
                        @if(isset($typeCounts[$typeKey]))
                            <span class="text-xs md:text-sm bg-pink-100 text-pink-700 rounded-full px-2 md:px-3 py-0.5">
                                {{ $typeCounts[$typeKey]['total'] }}
                            </span>
                        @endif
                    </h2>
                    @foreach($remindersGroup as $reminder)
                        <div class="flex items-center justify-between rounded-lg p-3 md:p-4 bg-gray-50">
                            <div class="flex items-center gap-3 md:gap-4 min-w-0">
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
                                <span class="material-icons text-2xl md:text-3xl text-pink-500 flex-shrink-0">{{ $icon }}</span>
                                <div class="min-w-0">
                                    <div class="font-medium text-gray-900 text-sm md:text-base truncate">{{ $title }}</div>
                                    <div class="text-xs md:text-sm text-gray-600 truncate">{{ $description }}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <button onclick="openDeleteModal('{{ $reminder->id }}')"
                                        class="w-7 h-7 md:w-8 md:h-8 flex items-center justify-center rounded-full bg-red-100 text-red-700 hover:bg-red-200 transition duration-150"
                                        title="Remove Reminder">
                                    <span class="material-icons text-sm md:text-base">delete</span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @empty
                    <p class="text-center text-gray-500 text-sm md:text-base">No reminders found.</p>
                @endforelse
            @else
                <!-- Display count for filtered category -->
                @if(isset($typeCounts[$type]))
                    <h2 class="text-lg md:text-xl font-bold text-pink-700 mt-4 md:mt-6 mb-2 md:mb-3 flex items-center gap-2">
                        <span>{{ ucfirst(str_replace('_', ' ', $type)) }} Reminders</span>
                        <span class="text-xs md:text-sm bg-pink-100 text-pink-700 rounded-full px-2 md:px-3 py-0.5">
                            {{ $typeCounts[$type]['total'] }}
                        </span>
                    </h2>
                @endif
                @forelse($reminders as $reminder)
                    <div class="flex items-center justify-between rounded-lg p-3 md:p-4 bg-gray-50">
                        <div class="flex items-center gap-3 md:gap-4 min-w-0">
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
                            <span class="material-icons text-2xl md:text-3xl text-pink-500 flex-shrink-0">{{ $icon }}</span>
                            <div class="min-w-0">
                                <div class="font-medium text-gray-900 text-sm md:text-base truncate">{{ $title }}</div>
                                <div class="text-xs md:text-sm text-gray-600 truncate">{{ $description }}</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <button onclick="openDeleteModal('{{ $reminder->id }}')"
                                    class="w-7 h-7 md:w-8 md:h-8 flex items-center justify-center rounded-full bg-red-100 text-red-700 hover:bg-red-200 transition duration-150"
                                    title="Remove Reminder">
                                <span class="material-icons text-sm md:text-base">delete</span>
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 text-sm md:text-base">No reminders found for this category.</p>
                @endforelse
            @endif

            <!-- Add New Reminder Button -->
            <a href="{{ route('reminders.create') }}" class="w-full border-2 border-dashed border-gray-300 rounded-lg py-3 md:py-4 text-gray-500 font-medium flex items-center justify-center gap-2 hover:bg-gray-50 transition text-sm md:text-base">
                <span class="material-icons text-lg md:text-xl">add</span>
                Add New Reminder
            </a>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <x-delete-modal
        title="Confirm Deletion"
        message="Are you sure you want to delete this reminder? This action cannot be undone."
        confirmText="Delete Reminder"
        feature="reminders"
    />
</div>
@endsection

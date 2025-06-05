@extends('layouts.vitality')

@php
use App\Constants\CheckInConstants;
@endphp

@section('title', 'Daily Check-ins')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script>
        window.CheckInConstants = {
            TITLE_MAX_LENGTH: {{ CheckInConstants::TITLE_MAX_LENGTH }}
        };

        // Make openDeleteModal available globally
        window.openDeleteModal = function(id) {
            // Set form action URL
            document.getElementById('deleteForm').action = `/checkins/${id}`;

            // Show the modal with fade in
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('hidden');
            // Trigger reflow to ensure the transition works
            modal.offsetHeight;
            modal.classList.remove('opacity-0');
            modal.querySelector('div').classList.remove('scale-95');
        };

        // Make closeDeleteModal available globally
        window.closeDeleteModal = function() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('opacity-0');
            modal.querySelector('div').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300); // Wait for fade out animation to complete
        };
    </script>
    @vite(['resources/js/checkins.js', 'resources/js/confetti.js'])
@endpush

@section('content')
<div class="w-full pl-0 md:pl-72">
    <div class="max-w-5xl mx-auto flex flex-col gap-8 px-6 py-8">
        <!-- Celebration Overlay -->
        <div id="celebrationOverlay" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 transition-opacity duration-300 opacity-0">
            <button onclick="document.getElementById('celebrationOverlay').classList.add('hidden')"
                    class="fixed top-4 right-4 bg-red-100 rounded-full p-2 shadow-md hover:bg-red-200 transition-colors border border-red-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="text-center">
                <img src="{{ asset('images/capybara-rub.gif') }}" alt="Celebration" class="w-64 h-64 mx-auto mb-4 animate-bounce">
                <div class="bg-pink-100 border-2 border-pink-300 rounded-xl px-8 py-4 inline-block animate-bounce">
                    <h2 class="text-4xl font-bold text-pink-600">GOOD JOB!</h2>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 transition-opacity duration-300 opacity-0">
            <div class="bg-white rounded-xl shadow-md p-6 max-w-sm w-full transform transition-transform duration-300 scale-95">
                <h3 class="text-lg font-medium mb-4">Confirm Deletion</h3>
                <p class="text-gray-600 mb-6">Are you sure you want to delete this check-in? This action cannot be undone.</p>
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
                            Delete Check-in
                        </button>
                    </form>
                </div>
            </div>
        </div>

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
                        @php
                            $completedCount = $checkins->where('isComplete', true)->count();
                            $totalCount = $checkins->count();
                            $percentage = $totalCount > 0 ? ($completedCount / $totalCount) * 100 : 0;
                        @endphp
                        <div id="progress-bar"
                             class="h-full bg-gradient-to-r from-pink-500 to-pink-400 rounded-full transition-all duration-300"
                             style="width: {{ $percentage }}%"
                             data-initial-percentage="{{ $percentage }}"
                        ></div>
                    </div>
                    <span id="progress-text"
                          class="text-pink-900 font-medium"
                          data-completed="{{ $completedCount }}"
                          data-total="{{ $totalCount }}"
                    >{{ $completedCount }}/{{ $totalCount }}</span>
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
                    @foreach($checkins as $checkin)
                        <div class="group grid grid-cols-[1fr,120px] gap-4 p-4 bg-pink-50 rounded-xl hover:bg-pink-100/50 transition-all relative">
                            <div class="min-w-0">
                                <span class="text-pink-900 break-all">{{$checkin->title}}</span>
                            </div>
                            <div class="flex justify-end">
                                <button
                                    type="button"
                                    data-id="{{ $checkin->id }}"
                                    data-completed="{{ $checkin->isComplete }}"
                                    class="complete-btn whitespace-nowrap text-white font-semibold px-4 py-2 rounded transition {{ $checkin->isComplete ? 'bg-green-500 hover:bg-green-600' : 'bg-pink-500 hover:bg-pink-600' }}"
                                    {{ $checkin->isComplete ? 'disabled' : '' }}
                                >
                                    {{ $checkin->isComplete ? 'Completed' : 'Not Done' }}
                                </button>
                            </div>
                            <form action="{{ route('checkins.destroy', $checkin) }}" method="POST" class="delete-form absolute -top-3 -right-3">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="openDeleteModal('{{ $checkin->id }}')" class="delete-btn h-6 w-6 rounded-full bg-red-100 hover:bg-red-200 flex items-center justify-center transition-colors shadow-sm border border-red-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Add Custom Check-in -->
            <div class="bg-pink-50 rounded-2xl shadow p-6 h-fit">
                <div class="font-bold text-pink-900 mb-4 text-lg flex items-center gap-2">
                    <span class="material-icons text-pink-400">add_circle</span>
                    Create Custom Check-in
                </div>
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative flex items-center gap-2">
                        <span class="material-icons text-green-500">check_circle</span>
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->has('title'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative flex items-center gap-2">
                        <span class="material-icons text-red-500">error_outline</span>
                        {{ $errors->first('title') }}:
                    </div>
                @endif
                <form id="custom-checkin-form" class="flex flex-col gap-2" method="POST" action="{{ route('checkins.store') }}">
                    @csrf
                    <div class="flex gap-3">
                        <input type="text"
                            id="custom-checkin-title"
                            name="title"
                            placeholder="Write a short title..."
                            class="flex-1 px-4 py-2.5 rounded-lg border border-pink-200 focus:ring-2 focus:ring-pink-300 text-sm @error('title') border-red-500 focus:ring-red-500 @enderror"
                            required
                            value="{{ old('title') }}"
                        >
                        <button type="submit" class="bg-pink-400 hover:bg-pink-500 text-white rounded-lg px-5 py-1.5 font-semibold w-24 transition text-sm self-start">
                            Add
                        </button>
                    </div>
                    <label for="custom-checkin-title" class="text-xs text-gray-500">Max {{ CheckInConstants::TITLE_MAX_LENGTH }} characters</label>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

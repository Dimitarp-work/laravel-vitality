@extends('layouts.vitality')

@section('title', 'Challenges')

@section('content')
    @if (session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded text-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="max-w-6xl mx-auto space-y-10">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-pink-900">Wellness Challenges</h1>
                <p class="text-sm text-pink-700">Optional activities to boost your wellness journey</p>
            </div>

            <!-- Filter + Create Button -->
            <div class="flex gap-2">
                <div class="relative" id="filterDropdownWrapper">
                    <button id="filterToggleBtn" class="bg-white border border-pink-300 text-pink-700 px-3 py-1.5 rounded hover:bg-pink-100 text-sm flex items-center gap-1">
                        <span class="material-icons text-pink-400 text-base">filter_list</span> Filter
                    </button>

                    <div id="filterDropdown" class="absolute right-0 mt-2 w-56 bg-white border border-pink-200 rounded shadow-md z-50 text-sm text-pink-700 hidden">
                        <div class="px-4 py-2 font-semibold border-b border-pink-100">Filter Challenges</div>
                        <a href="{{ route('challenges.index') }}" class="block px-4 py-2 hover:bg-pink-50">All Challenges</a>
                        @foreach (['active', 'available', 'completed'] as $status)
                            <a href="?filter={{ $status }}" class="block px-4 py-2 hover:bg-pink-50 {{ request('filter') === $status ? 'bg-pink-100 font-semibold' : '' }}">
                                {{ ucfirst($status) }} Challenges
                            </a>
                        @endforeach
                        <div class="px-4 py-2 font-semibold border-t border-pink-100">By Difficulty</div>
                        @foreach (['Beginner', 'Intermediate', 'Advanced'] as $difficulty)
                            <a href="?filter={{ $difficulty }}" class="block px-4 py-2 hover:bg-pink-50 {{ request('filter') === $difficulty ? 'bg-pink-100 font-semibold' : '' }}">
                                {{ $difficulty }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <a href="{{ route('challenges.create') }}" class="bg-pink-400 hover:bg-pink-500 text-white px-4 py-1.5 rounded text-sm flex items-center gap-1">
                    <span class="material-icons text-base">add_circle</span> Create New Challenge
                </a>
            </div>
        </div>

        <!-- Challenge Sections -->
        @foreach ([
            'Active Challenges' => $activeChallenges,
            'Available Challenges' => $availableChallenges,
            'Completed Challenges' => $completedChallenges,
        ] as $label => $challenges)
            @if($challenges->count())
                <div>
                    <h2 class="text-lg font-semibold text-pink-900 mt-6 mb-4">{{ $label }}</h2>
                    <div class="space-y-4">
                        @foreach($challenges as $challenge)
                            <div class="relative">
                                @include('challenges.partials.card', ['challenge' => $challenge])
                                @if(now()->lt($challenge->start_date))
                                    @can('update', $challenge)
                                        <div class="absolute top-2 right-4 flex gap-3">
                                            <a href="{{ route('challenges.edit', $challenge) }}" class="text-xs text-pink-500 hover:underline font-medium">Edit</a>
                                            <a href="{{ route('challenges.confirmDelete', $challenge) }}" class="text-xs text-red-500 hover:underline font-medium">Delete</a>
                                        </div>
                                    @endcan
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach

        <!-- No Results Message -->
        @if($activeChallenges->isEmpty() && $availableChallenges->isEmpty() && $completedChallenges->isEmpty())
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <p class="text-pink-700 text-lg font-semibold mb-2">No Challenges Found</p>
                <p class="text-sm text-pink-500">Try adjusting your filters or check back later.</p>
            </div>
        @endif
    </div>

    <!-- Filter Dropdown Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggleBtn = document.getElementById("filterToggleBtn");
            const dropdown = document.getElementById("filterDropdown");

            toggleBtn.addEventListener("click", function (e) {
                e.stopPropagation();
                dropdown.classList.toggle("hidden");
            });

            document.addEventListener("click", function (event) {
                const isClickInside = document.getElementById("filterDropdownWrapper").contains(event.target);
                if (!isClickInside) {
                    dropdown.classList.add("hidden");
                }
            });
        });
    </script>
@endsection

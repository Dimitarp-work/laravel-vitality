@extends('layouts.vitality')

@section('title', 'Challenges')

@section('content')
    @if (session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded text-sm mb-4">
            {{ session('success') }}
        </div>
    @endif
    <div class="max-w-6xl mx-auto space-y-10">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-pink-900">Wellness Challenges</h1>
                <p class="text-sm text-pink-700">Optional activities to boost your wellness journey</p>
            </div>
            <div class="flex gap-2">
                <div class="relative" id="filterDropdownWrapper">
                    <button id="filterToggleBtn" class="bg-white border border-pink-300 text-pink-700 px-3 py-1.5 rounded hover:bg-pink-100 text-sm flex items-center gap-1">
                        <span class="material-icons text-pink-400 text-base">filter_list</span> Filter
                    </button>

                    <div id="filterDropdown" class="absolute right-0 mt-2 w-56 bg-white border border-pink-200 rounded shadow-md z-50 text-sm text-pink-700 hidden">
                        <div class="px-4 py-2 font-semibold border-b border-pink-100">Filter Challenges</div>
                        <a href="{{ route('challenges.index') }}" class="block px-4 py-2 hover:bg-pink-50">All Challenges</a>
                        <a href="?filter=active" class="block px-4 py-2 hover:bg-pink-50 {{ request('filter') === 'active' ? 'bg-pink-100 font-semibold' : '' }}">Active Challenges</a>
                        <a href="?filter=available" class="block px-4 py-2 hover:bg-pink-50 {{ request('filter') === 'available' ? 'bg-pink-100 font-semibold' : '' }}">Available Challenges</a>
                        <a href="?filter=completed" class="block px-4 py-2 hover:bg-pink-50 {{ request('filter') === 'completed' ? 'bg-pink-100 font-semibold' : '' }}">Completed Challenges</a>
                        <div class="px-4 py-2 font-semibold border-t border-pink-100">By Difficulty</div>
                        <a href="?filter=Beginner" class="block px-4 py-2 hover:bg-pink-50 {{ request('filter') === 'Beginner' ? 'bg-pink-100 font-semibold' : '' }}">Beginner</a>
                        <a href="?filter=Intermediate" class="block px-4 py-2 hover:bg-pink-50 {{ request('filter') === 'Intermediate' ? 'bg-pink-100 font-semibold' : '' }}">Intermediate</a>
                        <a href="?filter=Advanced" class="block px-4 py-2 hover:bg-pink-50 {{ request('filter') === 'Advanced' ? 'bg-pink-100 font-semibold' : '' }}">Advanced</a>
                    </div>
                </div>
                <a href="{{ route('challenges.create') }}" class="bg-pink-400 hover:bg-pink-500 text-white px-4 py-1.5 rounded text-sm flex items-center gap-1">
                    <span class="material-icons text-base">add_circle</span> Create New Challenge
                </a>
            </div>
        </div>

        {{-- Active Challenges --}}
        @if(count($activeChallenges) > 0)
            <div>
                <h2 class="text-lg font-semibold text-pink-900 mb-4">Active Challenges</h2>
                <div class="space-y-4">
                    @foreach($activeChallenges as $challenge)
                        @include('challenges.partials.card', ['challenge' => $challenge])
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Available Challenges --}}
        @if(count($availableChallenges) > 0)
            <div>
                <h2 class="text-lg font-semibold text-pink-900 mt-6 mb-4">Available Challenges</h2>
                <div class="space-y-4">
                    @foreach($availableChallenges as $challenge)
                        @include('challenges.partials.card', ['challenge' => $challenge])
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Completed Challenges --}}
        @if(count($completedChallenges) > 0)
            <div>
                <h2 class="text-lg font-semibold text-pink-900 mt-6 mb-4">Completed Challenges</h2>
                <div class="space-y-4">
                    @foreach($completedChallenges as $challenge)
                        @include('challenges.partials.card', ['challenge' => $challenge])
                    @endforeach
                </div>
            </div>
        @endif

        @if(count($activeChallenges) + count($availableChallenges) + count($completedChallenges) === 0)
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <p class="text-pink-700 text-lg font-semibold mb-2">No Challenges Found</p>
                <p class="text-sm text-pink-500">Try adjusting your filters or check back later.</p>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggleBtn = document.getElementById("filterToggleBtn");
            const dropdown = document.getElementById("filterDropdown");

            // Toggle visibility
            toggleBtn.addEventListener("click", function (e) {
                e.stopPropagation(); // Prevent bubbling to document
                dropdown.classList.toggle("hidden");
            });

            // Close dropdown when clicking outside
            document.addEventListener("click", function (event) {
                const isClickInside = document.getElementById("filterDropdownWrapper").contains(event.target);
                if (!isClickInside) {
                    dropdown.classList.add("hidden");
                }
            });
        });
    </script>

@endsection

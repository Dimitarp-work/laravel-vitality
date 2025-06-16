@extends('layouts.vitality')

@section('title', 'Challenges')

@section('content')
    <div class="w-full pl-0 md:pl-72">
        <div class="max-w-6xl mx-auto px-6 py-8">
            @if (session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded text-sm mb-4">
                    {{ session('success') }}
                </div>
            @endif

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

            <!-- Participants Overlay -->
            <div id="participantsOverlay" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
                <div class="bg-white rounded-lg shadow-xl max-h-[80vh] w-full max-w-md overflow-y-auto p-6 relative">
                    <button onclick="toggleParticipantsOverlay(false)" class="absolute top-3 right-3 text-gray-400 hover:text-black text-xl">&times;</button>
                    <h2 class="text-xl font-semibold mb-4 text-pink-700">Participants</h2>
                    <ul id="participantsList" class="space-y-2">
                        <!-- Participants will be injected here -->
                    </ul>
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

    <!--Participant Overlay Script-->
    <script>
        function toggleParticipantsOverlay(show) {
            const overlay = document.getElementById('participantsOverlay');
            overlay.classList.toggle('hidden', !show);
        }

        async function openParticipantsOverlay(challengeId) {
            // Optional: Fetch via AJAX
            const response = await fetch(`/challenges/${challengeId}/participants`);
            const participants = await response.json();

            const list = document.getElementById('participantsList');
            list.innerHTML = ''; // Clear previous

            if (participants.length === 0) {
                list.innerHTML = '<li class="text-gray-500">No participants yet.</li>';
            } else {
                participants.forEach(user => {
                    const li = document.createElement('li');
                    li.textContent = user.name;
                    li.className = 'border-b pb-2 text-sm';
                    list.appendChild(li);
                });
            }

            toggleParticipantsOverlay(true);
        }
    </script>
@endsection

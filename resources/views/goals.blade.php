@extends('layouts.vitality')

@section('title', 'My Goals')

@section('content')
    <div class="w-full pl-0 md:pl-72">
        <div class="max-w-4xl mx-auto px-6 py-8">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
                <h1 class="text-2xl md:text-3xl font-bold text-pink-900 flex items-center gap-2">
                    <span class="material-icons text-pink-400">flag</span>
                    My Wellness Journey
                </h1>
                <a href="{{ route('goals.create') }}"
                   class="bg-pink-400 hover:bg-pink-500 text-white px-4 py-2 rounded-lg self-start sm:self-auto flex items-center transition-colors duration-200">
                    <span class="material-icons text-base mr-1">add_circle</span>
                    Add New Goal
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Recommendations Block --}}
            @if(isset($recommendations) && $recommendations->count())
                <div class="mb-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded">
                    <h3 class="font-semibold text-yellow-700 mb-2">Recommendations for you</h3>
                    <ul class="list-disc list-inside space-y-1 text-yellow-800">
                        @foreach($recommendations as $rec)
                            <li>{{ $rec['message'] }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Delete Confirmation Modal -->
            <div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-xl shadow-md p-6 max-w-sm w-full">
                    <h3 class="text-lg font-medium mb-4">Confirm Deletion</h3>
                    <p class="text-gray-600 mb-6">Are you sure you want to delete this goal? This action cannot be undone.</p>
                    <div class="flex justify-end gap-2">
                        <button onclick="document.getElementById('deleteModal').classList.add('hidden')"
                                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">
                            Cancel
                        </button>
                        <form id="deleteForm" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                                Delete Goal
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="mb-6">
                <div class="bg-pink-50 rounded-2xl shadow p-1.5 max-w-2xl mx-auto w-full mb-6">
                    <div class="flex space-x-2">
                        <a href="?tab=current"
                           class="flex-1 px-4 py-3 text-pink-900 font-medium rounded-lg {{ $activeTab === 'current' ? 'bg-white shadow-sm' : 'hover:bg-white/50' }} text-center transition-all">
                            Current Goals
                        </a>
                        <a href="?tab=achieved"
                           class="flex-1 px-4 py-3 text-pink-700 font-medium rounded-lg {{ $activeTab === 'achieved' ? 'bg-white shadow-sm' : 'hover:bg-white/50' }} text-center transition-all">
                            Achieved
                        </a>
                        <a href="?tab=badges"
                           class="flex-1 px-4 py-3 text-pink-700 font-medium rounded-lg {{ $activeTab === 'badges' ? 'bg-white shadow-sm' : 'hover:bg-white/50' }} text-center transition-all">
                            My Badges
                        </a>
                    </div>
                </div>

                <!-- Current Goals -->
                @if($activeTab === 'current')
                    <div class="grid grid-cols-1 gap-6">
                        @foreach($currentGoals as $goal)
                            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                                <div class="bg-pink-400 h-2" style="width: {{ $goal->progress }}%"></div>
                                <div class="p-6">
                                    <div class="flex items-start">
                                        <div class="text-3xl mr-4">{{ $goal->emoji }}</div>
                                        <div class="flex-grow">
                                            <h3 class="font-semibold text-lg mb-1 truncate" title="{{ $goal->title }}">
                                                {{ \Illuminate\Support\Str::limit($goal->title, 60) }}
                                            </h3>

                                            <p class="text-sm text-gray-500 mb-2" title="{{ $goal->description }}">
                                                {{ \Illuminate\Support\Str::limit($goal->description, 60) }}
                                            </p>

                                            <!-- Duration Display -->
                                            <div class="flex items-center gap-2 mb-4">
                                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">
                                                    Duration: {{ $goal->duration_value }} {{ $goal->duration_unit }}
                                                </span>
                                            </div>

                                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                                                <div class="w-full sm:w-3/4">
                                                    <div class="flex justify-between items-center">
                                                        <span class="text-sm font-medium">Your journey: {{ $goal->progress }}%</span>
                                                        <span class="text-xs bg-pink-100 text-pink-600 px-2 py-0.5 rounded-full">
                                                            +{{ $goal->xp }} XP on completion
                                                        </span>
                                                    </div>
                                                    <div class="w-full bg-gray-100 rounded-full h-2 mt-1">
                                                        <div class="bg-pink-400 h-2 rounded-full" style="width: {{ $goal->progress }}%"></div>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <div class="text-sm">
                                                        <span class="font-medium text-pink-600">{{ $goal->streak }} day flow 🌊</span>
                                                    </div>
                                                    <form action="{{ route('goals.daily-update', $goal->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                                class="border border-pink-400 text-pink-600 hover:bg-pink-50 px-3 py-1 rounded-lg text-sm transition-colors duration-200"
                                                            {{ $goal->progress >= 100 || $goal->progressLogs->where('user_id', auth()->id())->where('updated_on', now()->toDateString())->count() ? 'disabled' : '' }}>
                                                            Update
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ml-4 flex flex-col sm:flex-row items-start sm:items-center gap-2 mt-1 shrink-0">
                                            <a href="{{ route('goals.edit', $goal->id) }}" class="text-gray-400 hover:text-gray-600 h-8 w-8 p-0 flex items-center justify-center">
                                                <span class="material-icons text-base">edit</span>
                                            </a>

                                            <button onclick="openDeleteModal('{{ $goal->id }}')"
                                                    class="text-red-400 hover:text-red-600 h-8 w-8 p-0 flex items-center justify-center">
                                                <span class="material-icons text-base">delete</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if(count($currentGoals) === 0)
                            <div class="text-center text-gray-500 py-8">
                                <span class="material-icons text-4xl text-pink-300 mb-2">flag</span>
                                <p>You have no current goals. Add a new one!</p>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Achieved Goals -->
                @if($activeTab === 'achieved')
                    <div class="grid grid-cols-1 gap-6">
                        @foreach($achievedGoals as $goal)
                            <div class="bg-white rounded-xl shadow-md">
                                <div class="p-6">
                                    <div class="flex items-start">
                                        <div class="text-3xl mr-4">{{ $goal->emoji }}</div>
                                        <div class="flex-grow">
                                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-1">
                                                <h3 class="font-semibold text-lg">{{ $goal->title }}</h3>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-xs bg-pink-100 text-pink-600 px-2 py-1 rounded-full">Celebrated</span>
                                                    <span class="text-xs bg-green-100 text-green-600 px-2 py-1 rounded-full">+{{ $goal->xp }} XP</span>
                                                </div>
                                            </div>
                                            <p class="text-sm text-gray-500 mb-2">{{ $goal->description }}</p>
                                            <p class="text-xs text-gray-500">Achieved on {{ $goal->achieved_at->format('M j, Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if(count($achievedGoals) === 0)
                            <div class="text-center text-gray-500 py-8">
                                <span class="material-icons text-4xl text-pink-300 mb-2">emoji_events</span>
                                <p>No goals achieved yet.</p>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Badges -->
                @if($activeTab === 'badges')
                    <div class="mb-6">
                        <h2 class="text-lg font-medium mb-2">My Badges</h2>
                        <p class="text-sm text-gray-500 mb-4">
                            Badges are earned passively as you use the app. They reflect your wellness journey and achievements.
                        </p>

                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            @foreach($badges as $badge)
                                <div class="bg-white rounded-xl shadow-md {{ $badge['earned'] ? '' : 'opacity-70' }}">
                                    <div class="p-4 text-center">
                                        <div class="text-5xl mb-2">{{ $badge['emoji'] }}</div>
                                        <h3 class="font-semibold">{{ $badge['name'] }}</h3>
                                        <p class="text-xs text-gray-500">{{ $badge['description'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal(goalId) {
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `/goals/${goalId}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }
    </script>
@endsection

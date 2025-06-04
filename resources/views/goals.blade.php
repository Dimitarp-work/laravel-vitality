@extends('layouts.vitality')

@section('title', 'My Goals')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-pink-600">My Wellness Journey</h1>
            <button onclick="document.getElementById('goalForm').classList.toggle('hidden')"
                    class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg self-start sm:self-auto flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Add New Goal
            </button>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- New Goal Form -->
        <div id="goalForm" class="hidden mb-12 bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6">
                <form action="{{ route('goals.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Goal Title *</label>
                        <input type="text" name="title" required value="{{ old('title') }}"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 @error('title') border-red-500 @enderror">
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="3"
                                  class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Icon *</label>
                            <input type="text" name="emoji" maxlength="2" placeholder="🏋️" value="{{ old('emoji') }}"
                                   class="w-full px-4 py-2 border rounded-lg text-2xl h-[42px] text-center focus:ring-2 focus:ring-pink-500 @error('emoji') border-red-500 @enderror">
                            @error('emoji') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">XP Reward *</label>
                            <input type="number" name="xp" min="10" max="1000" value="{{ old('xp', 50) }}"
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500 @error('xp') border-red-500 @enderror">
                            @error('xp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Duration Fields -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Duration Value *</label>
                            <input type="number" name="duration_value" min="1" value="{{ old('duration_value', 7) }}"
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500 @error('duration_value') border-red-500 @enderror">
                            @error('duration_value') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Duration Unit *</label>
                            <select name="duration_unit"
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500 @error('duration_unit') border-red-500 @enderror">
                                <option value="days" {{ old('duration_unit', 'days') === 'days' ? 'selected' : '' }}>Days</option>
                                <option value="hours" {{ old('duration_unit') === 'hours' ? 'selected' : '' }}>Hours</option>
                            </select>
                            @error('duration_unit') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="document.getElementById('goalForm').classList.add('hidden')"
                                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">Cancel</button>
                        <button type="submit"
                                class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg flex items-center">
                            Create Goal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Goal Form -->
        <div id="editGoalForm" class="hidden mb-12 bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6">
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Goal Title *</label>
                        <input type="text" name="title" id="editTitle" required
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="editDescription" rows="3"
                                  class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500"></textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Icon *</label>
                            <input type="text" name="emoji" id="editEmoji" maxlength="2" placeholder="🏋️"
                                   class="w-full px-4 py-2 border rounded-lg text-2xl h-[42px] text-center focus:ring-2 focus:ring-pink-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">XP Reward *</label>
                            <input type="number" name="xp" id="editXp" min="10" max="1000"
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500">
                        </div>
                    </div>

                    <!-- Duration Fields -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Duration Value *</label>
                            <input type="number" name="duration_value" id="editDurationValue" min="1"
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Duration Unit *</label>
                            <select name="duration_unit" id="editDurationUnit"
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500">
                                <option value="days">Days</option>
                                <option value="hours">Hours</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="document.getElementById('editGoalForm').classList.add('hidden')"
                                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">Cancel</button>
                        <button type="submit"
                                class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg flex items-center">
                            Update Goal
                        </button>
                    </div>
                </form>
            </div>
        </div>

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
            <div class="grid grid-cols-3 gap-2 mb-6">
                <a href="?tab=current" class="{{ $activeTab === 'current' ? 'bg-pink-200 text-pink-800' : 'bg-pink-100 text-pink-600' }} px-4 py-2 rounded-lg text-center font-medium">Current Goals</a>
                <a href="?tab=achieved" class="{{ $activeTab === 'achieved' ? 'bg-pink-200 text-pink-800' : 'bg-pink-100 text-pink-600' }} px-4 py-2 rounded-lg text-center font-medium">Achieved</a>
                <a href="?tab=badges" class="{{ $activeTab === 'badges' ? 'bg-pink-200 text-pink-800' : 'bg-pink-100 text-pink-600' }} px-4 py-2 rounded-lg text-center font-medium">My Badges</a>
            </div>

            <!-- Current Goals -->
            @if($activeTab === 'current')
                <div class="grid grid-cols-1 gap-6">
                    @foreach($currentGoals as $goal)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden">
                            <div class="bg-pink-600 h-2" style="width: {{ $goal->progress }}%"></div>
                            <div class="p-6">
                                <div class="flex items-start">
                                    <div class="text-3xl mr-4">{{ $goal->emoji }}</div>
                                    <div class="flex-grow">
                                        <h3 class="font-semibold text-lg mb-1">{{ $goal->title }}</h3>
                                        <p class="text-sm text-gray-500 mb-2">{{ $goal->description }}</p>

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
                                                    <div class="bg-pink-600 h-2 rounded-full" style="width: {{ $goal->progress }}%"></div>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <div class="text-sm">
                                                    <span class="font-medium text-pink-600">{{ $goal->streak }} day flow 🌊</span>
                                                </div>
                                                <form action="{{ route('goals.daily-update', $goal->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                            class="border border-pink-600 text-pink-600 hover:bg-pink-50 px-3 py-1 rounded-lg text-sm"
                                                        {{ $goal->progress >= 100 || $goal->progressLogs->where('user_id', auth()->id())->where('updated_on', now()->toDateString())->count() ? 'disabled' : '' }}>
                                                        Update
                                                    </button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                                        <button onclick="openEditModal('{{ $goal->id }}', `{{ addslashes($goal->title) }}`, `{{ addslashes($goal->description) }}`, '{{ $goal->emoji }}', '{{ $goal->xp }}', '{{ $goal->duration_value }}', '{{ $goal->duration_unit }}')"
                                                class="text-gray-400 hover:text-gray-600 h-8 w-8 p-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                        <button onclick="openDeleteModal('{{ $goal->id }}')"
                                                class="text-red-400 hover:text-red-600 h-8 w-8 p-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if(count($currentGoals) === 0)
                        <p class="text-center text-gray-500">You have no current goals. Add a new one!</p>
                    @endif
                </div>
            @endif

            <!-- Achieved Goals -->
            @if($activeTab === 'achieved')
                <div class="grid grid-cols-1 gap-6">
                    @foreach($achievedGoals as $goal)
                        <div class="bg-gray-50 rounded-xl shadow-md">
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
                        <p class="text-center text-gray-500">No goals achieved yet.</p>
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
                                <div class="p-4 flex flex-col items-center text-center">
                                    <div class="w-16 h-16 rounded-full bg-pink-100 flex items-center justify-center text-2xl my-3">
                                        {{ $badge['icon'] ?? '🏆' }}
                                    </div>
                                    <h3 class="font-medium text-sm mb-1">{{ $badge['name'] }}</h3>
                                    <p class="text-xs text-gray-500 mb-2">{{ $badge['description'] }}</p>

                                    @if($badge['earned'])
                                        <span class="text-xs text-green-600 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Earned on {{ $badge['date'] }}
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-500">
                                            {{ $badge['progress'] }} of {{ $badge['maxProgress'] ?? 10 }} completed
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function openEditModal(id, title, description, emoji, xp, durationValue, durationUnit) {
            // Set form action URL
            document.getElementById('editForm').action = `/goals/${id}`;

            // Fill form with current values
            document.getElementById('editTitle').value = title;
            document.getElementById('editDescription').value = description;
            document.getElementById('editEmoji').value = emoji;
            document.getElementById('editXp').value = xp;
            document.getElementById('editDurationValue').value = durationValue;
            document.getElementById('editDurationUnit').value = durationUnit;

            // Show the modal
            document.getElementById('editGoalForm').classList.remove('hidden');
        }

        function openDeleteModal(id) {
            // Set form action URL
            document.getElementById('deleteForm').action = `/goals/${id}`;

            // Show the modal
            document.getElementById('deleteModal').classList.remove('hidden');
        }
    </script>
@endsection

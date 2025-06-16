@props(['notifications' => session('notifications', [])])

<div x-data="{ open: false, clearing: false }" class="relative inline-block">
    <!-- Notification Bell -->
    <button @click="open = !open" class="relative p-2 text-gray-600 hover:text-pink-600 focus:outline-none">
        <span class="material-icons">notifications</span>
        @if(count($notifications) > 0)
            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-pink-600 rounded-full">
                {{ count($notifications) }}
            </span>
        @endif
    </button>

    <!-- Dropdown -->
    <div x-show="open"
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute md:left-full left-auto right-[-8rem] top-12 md:top-0 md:ml-2 w-80 bg-white rounded-lg shadow-lg overflow-hidden z-50">

        <div class="p-4 border-b">
            <h3 class="text-lg font-semibold text-gray-900">Notifications</h3>
        </div>

        <div x-show="!clearing" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="max-h-96 overflow-y-auto">
                @forelse($notifications as $notification)
                    <div class="p-4 border-b hover:bg-gray-50">
                        <div class="flex items-start gap-3">
                            <span class="material-icons text-pink-500">{{ $notification['icon'] }}</span>
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">{{ $notification['title'] }}</p>
                                <p class="text-sm text-gray-600">{{ $notification['message'] }}</p>
                                @if(isset($notification['progress']))
                                    <div class="mt-2">
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-pink-600 h-2 rounded-full" style="width: {{ $notification['progress'] }}%"></div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Progress: {{ $notification['progress'] }}%</p>
                                    </div>
                                @endif
                                <p class="text-xs text-gray-400 mt-1">{{ \Carbon\Carbon::parse(session('notification_timestamps', [])[$loop->index] ?? now())->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-gray-500">
                        No new notifications
                    </div>
                @endforelse
            </div>
        </div>

        <div class="p-4 border-t bg-gray-50">
            <a href="{{ route('settings.index') }}" class="text-sm text-pink-600 hover:text-pink-700 font-medium">
                Notification Settings
            </a>
            <form x-ref="clearForm" action="{{ route('notifications.clear') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" @click.prevent="clearing = true; setTimeout(() => $refs.clearForm.submit(), 300)" class="w-full text-center text-sm text-gray-500 hover:text-gray-700 font-medium p-2 rounded-md bg-gray-100 hover:bg-gray-200">
                    Clear All Notifications
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('notificationsComponent', () => ({
            open: false,
            clearing: false,
        }));
    });
</script>

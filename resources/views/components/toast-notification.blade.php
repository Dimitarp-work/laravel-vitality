@props(['notification'])

<div x-data="{ show: true }"
     x-show="show"
     x-transition:enter="transform ease-out duration-300 transition"
     x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
     x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
     x-transition:leave="transition ease-in duration-100"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed top-4 right-4 z-50 w-96 bg-white rounded-lg shadow-lg overflow-hidden"
     @click.away="show = false">

    <div class="p-4">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <span class="material-icons text-2xl text-pink-500">{{ $notification['icon'] }}</span>
            </div>
            <div class="ml-3 w-0 flex-1">
                <p class="text-sm font-medium text-gray-900">{{ $notification['title'] }}</p>
                <p class="mt-1 text-sm text-gray-500">{{ $notification['message'] }}</p>
                @if(isset($notification['progress']))
                    <div class="mt-2">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-pink-600 h-2 rounded-full" style="width: {{ $notification['progress'] }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Progress: {{ $notification['progress'] }}%</p>
                    </div>
                @endif
            </div>
            <div class="ml-4 flex-shrink-0 flex">
                <button @click="show = false" class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none">
                    <span class="material-icons text-base">close</span>
                </button>
            </div>
        </div>
    </div>
</div>

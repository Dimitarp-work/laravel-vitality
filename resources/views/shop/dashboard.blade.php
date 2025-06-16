<x-app-layout>
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-xl font-bold">
                Welcome, {{ Auth::user()->name }}

                @if(Auth::user()->activeBadge)
    @php
        $badge = Auth::user()->activeBadge;
        $style = $badge->style ?? [];
    @endphp

    <span class="ml-2 inline-flex items-center gap-2 px-3 py-1 rounded shadow
                  {{ $style['bg'] ?? 'bg-yellow-300' }}
                  {{ $style['text'] ?? 'text-black' }}">
        @if(!empty($style['icon']))
            <i class="{{ $style['icon'] }}"></i>
        @endif
        {{ $badge->name }}
    </span>
@endif


            <a href="{{ route('shop.index') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded shadow">
               Go to Shop
            </a>
        </div>

        <p>You have <strong>{{ Auth::user()->credits }}</strong> credits.</p>
    </div>
</x-app-layout>

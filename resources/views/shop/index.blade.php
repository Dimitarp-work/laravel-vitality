@extends('layouts.vitality')

@section('title', 'Customization Store')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold text-pink-800">Customization Store</h1>
        <span class="bg-pink-100 text-pink-800 text-sm font-semibold px-4 py-2 rounded-full shadow">{{ Auth::user()->credits }} Credits</span>
    </div>

    @php
        $grouped = $storeItems->groupBy('category');
    @endphp

    @foreach($grouped as $category => $items)
        <h2 class="text-lg font-bold text-pink-700 mt-8 mb-3">Profile {{ ucfirst($category) }}</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($items as $item)
                @php
                    $owned = $item->item && Auth::user()->{$category.'s'}->contains($item->item_id);
                    $active = Auth::user()->{'active_'.$category.'_id'} === $item->item_id;
                    $isBadge = $category === 'badge';
                    $style = $item->item->style ?? [];
                @endphp

                <div class="bg-white rounded-xl shadow p-4 flex flex-col items-center text-center gap-2 border">
                   @if($item->item->image_url)
    <img src="{{ asset($item->item->image_url) }}"
         alt="{{ $item->item->name }}"
         class="w-20 h-20 object-contain rounded mx-auto" />
@endif

                    <h3 class="font-semibold text-pink-800 text-sm">{{ $item->item->name }}</h3>
                    <p class="text-xs text-pink-600">{{ $item->item->description }}</p>

                    @if($owned)
                        @if($active)
                            <span class="text-green-600 text-sm font-medium">✔ Equipped</span>
                        @elseif(!$isBadge)
                            <form method="POST" action="{{ route('customize.activate', [$category, $item->item_id]) }}">
                                @csrf
                                <button class="bg-pink-100 text-pink-700 text-xs rounded px-3 py-1 hover:bg-pink-200">Equip</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('badges.toggle', $item->item_id) }}">
                                @csrf
                                <button class="bg-pink-100 text-pink-700 text-xs rounded px-3 py-1 hover:bg-pink-200">Add to Profile</button>
                            </form>
                        @endif
                    @else
                        <form method="POST" action="{{ route('store.purchase', $item->id) }}">
                            @csrf
                            <button class="bg-pink-400 text-white text-xs rounded px-3 py-1 hover:bg-pink-500 transition">
                                Purchase @if($item->price) ({{ $item->price }} Credits) @endif
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    @endforeach
</div>
@endsection

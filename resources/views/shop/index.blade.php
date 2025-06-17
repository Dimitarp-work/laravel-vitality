@extends('layouts.vitality')

@section('title', 'Customization Store')

@section('content')
<div class="w-full pl-0 md:pl-72">
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-pink-800">Customization Store</h1>
            <span class="bg-pink-100 text-pink-800 text-sm font-semibold px-4 py-2 rounded-full shadow">{{ Auth::user()->credits }} Credits</span>
        </div>

        @php
            $grouped = $storeItems->groupBy('category');
        @endphp

        @foreach($grouped as $category => $items)
         @if($category === 'banner')
        @continue
    @endif
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
     @if($banners->count())
    <div class="mb-8">
        <h2 class="text-lg font-semibold text-pink-900 mb-4">Banners</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($banners as $storeItem)
                @php
                    $banner = $storeItem->item;
                    $owned = auth()->user()->banners->contains($banner->id);
                    $active = auth()->user()->banner_id === $banner->id;
                        $isActive = auth()->user()->banner_id === $banner->id;

                @endphp

               <div class="bg-white rounded-lg shadow p-4 flex flex-col gap-2 transition
    {{ $isActive ? 'border-2 border-pink-400 ring ring-pink-300' : 'border hover:border-pink-200' }}">

                    <div class="h-32 rounded-lg overflow-hidden">
                        <img src="{{ $banner->image_url }}" alt="{{ $banner->name }}" class="w-full h-full object-cover">
                    </div>
                    <div class="text-pink-900 font-bold">{{ $banner->name }}</div>
@if($owned)
    @if($active)
        <form method="POST" action="{{ route('appearance.reset') }}">
            @csrf
            <button class="bg-pink-100 text-pink-700 rounded px-3 py-1 text-sm font-semibold hover:bg-pink-200 transition">
                Reset to Default
            </button>
        </form>
    @else
        <form method="POST" action="{{ route('appearance.update') }}">
            @csrf
            <input type="hidden" name="banner_id" value="{{ $banner->id }}">
            <button class="bg-pink-200 text-pink-800 rounded px-3 py-1 text-sm font-semibold hover:bg-pink-300 transition">
                Apply
            </button>
        </form>
    @endif
@else
    <form method="POST" action="{{ route('store.purchase', $storeItem->id) }}">
        @csrf
        <button class="bg-pink-400 text-white rounded px-3 py-1 text-sm font-semibold hover:bg-pink-500 transition">
            Buy ({{ $storeItem->price }} Credits)
        </button>
    </form>
@endif


                </div>
            @endforeach
        </div>
    </div>
@endif
@endsection

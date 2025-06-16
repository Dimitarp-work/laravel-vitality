@extends('layouts.vitality')
@section('title', 'Appearance Settings')

@section('content')
<div class="w-full pl-0 md:pl-72">
    <div class="max-w-4xl mx-auto px-6 py-8">
        <h1 class="text-2xl font-bold text-pink-800 mb-6">Choose Your Banner</h1>
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('appearance.update') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @csrf
    @foreach($banners as $banner)
        <label class="block border rounded-lg shadow hover:ring-2 hover:ring-pink-400 transition overflow-hidden">
            <input type="radio" name="banner_id" value="{{ $banner->id }}"
                   class="sr-only peer"
                   {{ auth()->user()->banner_id === $banner->id ? 'checked' : '' }}>
            <img src="{{ $banner->image_url }}" alt="{{ $banner->name }}" class="w-full h-32 object-cover">
            <div class="p-2 text-center font-semibold text-pink-900 peer-checked:bg-pink-200">
                {{ $banner->name }}
            </div>
        </label>
    @endforeach

    <button type="submit"
            class="col-span-full mt-4 bg-pink-400 hover:bg-pink-500 text-white px-6 py-2 rounded shadow">
        Save Selection
    </button>
</form>
<form action="{{ route('appearance.reset') }}" method="POST" class="mt-4">
    @csrf
    <button type="submit"
            class="bg-gray-200 hover:bg-gray-300 text-pink-900 px-4 py-2 rounded shadow text-sm">
        Reset to Default Banner
    </button>
</form>
        </form>
    </div>
</div>
@endsection

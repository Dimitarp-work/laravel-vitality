@extends('layouts.vitality')

@section('title', 'Delete Challenge')

@section('content')
    <div class="max-w-xl mx-auto bg-white rounded-xl shadow p-6 text-center">
        <h1 class="text-2xl font-bold text-pink-900 mb-4">Confirm Deletion</h1>
        <p class="text-pink-700 mb-6">Are you sure you want to delete the challenge:</p>

        <div class="bg-pink-50 border border-pink-200 rounded p-4 mb-6">
            <h2 class="text-lg font-semibold text-pink-800">{{ $challenge->title }}</h2>
            <p class="text-sm text-pink-600">{{ $challenge->description }}</p>
        </div>

        <div class="flex justify-center gap-4">
            <form action="{{ route('challenges.destroy', $challenge) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded font-semibold">
                    Yes, Delete It
                </button>
            </form>
            <a href="{{ route('challenges.index') }}" class="bg-gray-200 hover:bg-gray-300 text-pink-800 px-5 py-2 rounded font-semibold">
                Cancel
            </a>
        </div>
    </div>
@endsection

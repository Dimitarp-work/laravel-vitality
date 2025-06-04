@extends('layouts.vitality')

@section('content')
    <h1 class="text-3xl font-bold text-pink-300">Create Article</h1>
    <br>
    <form method="POST" action="{{ route('articles.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title" class="text-xl text-pink-300">Title :</label>
            <br>
            <input
                type="text"
                name="title"
                class="form-control bg-gray-200 rounded-lg shadow px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-300"
                required>
        </div>
        <div class="form-group mt-4">
            <label for="content" class="text-xl text-pink-300">Content :</label>
            <br>
            <textarea
                name="content"
                class="form-control bg-gray-200 rounded-lg shadow px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-300"
                required>{{ old('content') }}</textarea>
        </div>
        <div class="form-group mt-4">
            <label for="image" class="text-xl text-pink-300 block mb-2">Image :</label>
            <label
                class="w-fit flex items-center gap-2 hover:bg-gray-300 bg-white text-gray-400 hover:text-gray-700 font-semibold px-6 py-2 rounded-lg shadow cursor-pointer transition">
                <span class="material-icons text-base">add_a_photo</span>
                Choose File
                <input type="file" name="image" class="hidden"
                       onchange="document.getElementById('file-name').textContent = this.files[0]?.name || 'No file chosen';">
            </label>
            <span id="file-name" class="ml-3 text-gray-500">No file chosen</span>
        </div>
        <button type="submit"
                class="inline-flex items-center gap-2 hover:bg-green-100 bg-white text-gray-400 hover:text-green-500 mt-3 font-semibold px-6 py-2 rounded-lg shadow cursor-pointer transition">
            <span class="material-icons text-base">add_circle</span>
            Create
        </button>
        <a href="/articles"
           class="inline-flex items-center gap-2 hover:bg-pink-100 bg-white text-gray-400 hover:text-pink-600 mt-3 font-semibold px-6 py-2 rounded-lg shadow cursor-pointer transition">
            <span class="material-icons text-base">close</span>
            Cancel
        </a>

    </form>
@endsection

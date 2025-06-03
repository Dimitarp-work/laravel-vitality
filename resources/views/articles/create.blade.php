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
                class="hover:bg-gray-300 bg-white text-gray-400 hover:text-gray-700 font-semibold px-6 py-2 rounded-lg shadow cursor-pointer transition inline-block">Choose
                File
                <input type="file" name="image" class="hidden"
                       onchange="document.getElementById('file-name').textContent = this.files[0]?.name || 'No file chosen';">
            </label>
            <span id="file-name" class="ml-3 text-gray-500">No file chosen</span>
        </div>
        <button type="submit"
                class="hover:bg-green-100 bg-white text-gray-400 hover:text-green-500 btn btn-primary mt-3 font-semibold px-6 py-2 rounded-lg shadow cursor-pointer transition inline-block">
            Create
        </button>
        <a href="/articles"
           class="hover:bg-pink-100 bg-white text-gray-400 hover:text-pink-600 btn btn-secondary mt-3 font-semibold px-6 py-2 rounded-lg shadow cursor-pointer transition inline-block">
            Cancel
        </a>

    </form>
@endsection

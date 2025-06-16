@extends('layouts.admin')

@section('content')
    <h1 class="text-3xl font-bold text-pink-300">Edit Article</h1>
    <br>
    <form method="POST" action="{{ route('articles.update', $article) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title" class="text-xl text-pink-300">Title :</label>
            <br>
            <input
                type="text"
                name="title"
                value="{{ old('title', $article->title) }}"
                class="form-control bg-gray-200 rounded-lg shadow px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-300  w-full @error('title') border-red-500 @enderror"
                required>
            @error('title')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group mt-4">
            <label for="content" class="text-xl text-pink-300">Content :</label>
            <br>
            <textarea
                name="content"
                class="form-control bg-gray-200 rounded-lg shadow px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-300 w-full @error('content') border-red-500 @enderror"
                rows="8"
                required>{{ old('content', $article->content) }}</textarea>
            @error('content')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group mt-4">
            <label for="image" class="text-xl text-pink-300 block mb-2">Image :</label>
            @if ($article->image)
                <div class="flex items-center gap-4 mb-3">
                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}"
                         class="w-32 h-20 object-cover rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <input type="checkbox" name="clear_image" id="clear_image" value="1"
                               class="rounded border-gray-300 text-pink-600 shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-200 focus:ring-opacity-50">
                        <label for="clear_image" class="ml-2 text-sm text-gray-700">Clear current image</label>
                    </div>
                </div>
            @endif
            <label
                class="w-fit flex items-center gap-2 hover:bg-gray-300 bg-white text-gray-400 hover:text-gray-700 font-semibold px-6 py-2 rounded-lg shadow cursor-pointer transition">
                <span class="material-icons text-base">add_a_photo</span>
                Choose File
                <input
                    type="file"
                    name="image"
                    class="hidden"
                    onchange="document.getElementById('file-name').textContent = this.files[0]?.name || 'No file chosen';"
                >
            </label>
            <span id="file-name" class="ml-3 text-gray-500">No file chosen</span>
            <p class="text-sm text-gray-500 mt-1">Allowed file types: JPG, JPEG, PNG, GIF, SVG, WEBP (Max 8MB)</p>
            @error('image')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group mt-4">
            <label class="text-xl text-pink-300 block mb-2">Tags :</label>
            <div id="tag-selection-container"
                 class="flex flex-wrap gap-2 p-3 bg-gray-200 rounded-lg shadow w-full @error('tags') border border-red-500 @enderror">
                @forelse($tags as $tag)
                    <span class="tag-item
                        bg-gray-300 text-gray-700
                        hover:bg-gray-400 hover:text-gray-800
                        rounded-full px-3 py-1 text-sm font-semibold cursor-pointer transition
                        select-none"
                          data-tag-id="{{ $tag->id }}"
                          data-tag-name="{{ $tag->name }}"
                          @if(in_array($tag->id, old('tags', $articleTags)))
                              data-selected="true"
                          @endif
                    >
                        {{ $tag->name }}
                    </span>
                @empty
                    <p class="text-gray-500 text-sm">No tags available. Please create some first.</p>
                @endforelse
            </div>
            <input type="hidden" name="tags[]" id="hidden-tags-input" required>
            @error('tags')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
            @error('tags.*')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <button
            type="submit"
            class="inline-flex items-center gap-2 hover:bg-green-100 bg-white text-gray-400 hover:text-green-500 mt-3 font-semibold px-6 py-2 rounded-lg shadow cursor-pointer transition">
            <span class="material-icons text-base">upgrade</span>
            Update
        </button>
        <a href="javascript:history.back()"
           class="inline-flex items-center gap-2 hover:bg-pink-100 bg-white text-gray-400 hover:text-pink-600 mt-3 font-semibold px-6 py-2 rounded-lg shadow cursor-pointer transition">
            <span class="material-icons text-base">close</span>
            Cancel
        </a>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tagItems = document.querySelectorAll('.tag-item');
            const hiddenTagsInput = document.getElementById('hidden-tags-input');
            let selectedTagIds = [];

            tagItems.forEach(item => {
                if (item.dataset.selected === 'true') {
                    selectedTagIds.push(item.dataset.tagId);
                    item.classList.add('selected-tag', 'bg-pink-300', 'text-white');
                    item.classList.remove('bg-gray-300', 'text-gray-700');
                } else {
                    item.classList.add('bg-gray-300', 'text-gray-700');
                    item.classList.remove('selected-tag', 'bg-pink-300', 'text-white');
                }
            });
            updateHiddenInput();

            tagItems.forEach(tagItem => {
                tagItem.addEventListener('click', function () {
                    const tagId = this.dataset.tagId;

                    if (selectedTagIds.includes(tagId)) {
                        selectedTagIds = selectedTagIds.filter(id => id !== tagId);
                        this.classList.remove('selected-tag', 'bg-pink-300', 'text-white');
                        this.classList.add('bg-gray-300', 'text-gray-700');
                        this.dataset.selected = 'false';
                    } else {
                        selectedTagIds.push(tagId);
                        this.classList.add('selected-tag', 'bg-pink-300', 'text-white');
                        this.classList.remove('bg-gray-300', 'text-gray-700');
                        this.dataset.selected = 'true';
                    }
                    updateHiddenInput();
                });
            });

            function updateHiddenInput() {
                const parentForm = hiddenTagsInput.form;
                const existingDynamicInputs = parentForm.querySelectorAll('input.dynamic-tag-input');
                existingDynamicInputs.forEach(input => input.remove());

                if (selectedTagIds.length > 0) {
                    selectedTagIds.forEach(id => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'tags[]';
                        input.value = id;
                        input.classList.add('dynamic-tag-input');
                        parentForm.appendChild(input);
                    });

                    hiddenTagsInput.name = '__temp_tags_placeholder__';
                    hiddenTagsInput.removeAttribute('required');
                    hiddenTagsInput.value = '';
                } else {
                    hiddenTagsInput.name = 'tags[]';
                    hiddenTagsInput.setAttribute('required', 'required');
                    hiddenTagsInput.value = '';
                }
            }

            const form = document.querySelector('form');
            form.addEventListener('submit', function (event) {
                if (selectedTagIds.length === 0 && hiddenTagsInput.hasAttribute('required')) {
                }
            });
        });
    </script>
@endsection

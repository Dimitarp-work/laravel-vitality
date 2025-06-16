@extends('layouts.admin')

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
                class="form-control bg-gray-200 rounded-lg shadow px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-300 w-full @error('title') border-red-500 @enderror"
                value="{{ old('title') }}"
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
                required>{{ old('content') }}</textarea>
            @error('content')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
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
                        selected-hover:bg-pink-400 selected-hover:text-white
                        rounded-full px-3 py-1 text-sm font-semibold cursor-pointer transition
                        select-none"
                          data-tag-id="{{ $tag->id }}"
                          data-tag-name="{{ $tag->name }}"
                          @if(in_array($tag->id, old('tags', [])))
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

        <button type="submit"
                class="inline-flex items-center gap-2 hover:bg-green-100 bg-white text-gray-400 hover:text-green-500 mt-3 font-semibold px-6 py-2 rounded-lg shadow cursor-pointer transition">
            <span class="material-icons text-base">add_circle</span>
            Create
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

            function applyTagClasses(item, isSelected) {
                if (isSelected) {
                    item.classList.add('selected-tag', 'bg-pink-300', 'text-white', 'selected-hover:bg-pink-400', 'selected-hover:text-white');
                    item.classList.remove('bg-gray-300', 'text-gray-700', 'hover:bg-gray-400', 'hover:text-gray-800');
                } else {
                    item.classList.add('bg-gray-300', 'text-gray-700', 'hover:bg-gray-400', 'hover:text-gray-800');
                    item.classList.remove('selected-tag', 'bg-pink-300', 'text-white', 'selected-hover:bg-pink-400', 'selected-hover:text-white');
                }
            }

            tagItems.forEach(item => {
                const isInitiallySelected = item.dataset.selected === 'true';
                if (isInitiallySelected) {
                    selectedTagIds.push(item.dataset.tagId);
                }
                applyTagClasses(item, isInitiallySelected);
            });
            updateHiddenInput();

            tagItems.forEach(tagItem => {
                tagItem.addEventListener('click', function () {
                    const tagId = this.dataset.tagId;
                    let isSelected = selectedTagIds.includes(tagId);

                    if (isSelected) {
                        selectedTagIds = selectedTagIds.filter(id => id !== tagId);
                        this.dataset.selected = 'false';
                        isSelected = false;
                    } else {
                        selectedTagIds.push(tagId);
                        this.dataset.selected = 'true';
                        isSelected = true;
                    }
                    applyTagClasses(this, isSelected);
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

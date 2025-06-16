@extends('layouts.admin')

@section('title', 'Create Article')

@section('content')
    <div class="max-w-4xl mx-auto px-6 py-8">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-pink-900 flex items-center gap-2">
                <span class="material-icons text-pink-400">add_circle</span>
                Create Article
            </h1>
            <a href="#" onclick="history.back(); return false;"
               class="bg-pink-400 hover:bg-pink-500 text-white px-4 py-2 rounded-lg self-start sm:self-auto flex items-center transition-colors duration-200">
                Back<span class="material-icons text-base mr-1">redo</span>
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8">
            <form method="POST" action="{{ route('articles.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-pink-900 mb-2">Title</label>
                        <input
                            type="text"
                            name="title"
                            id="title"
                            class="w-full px-4 py-2.5 rounded-lg border border-pink-200 focus:ring-2 focus:ring-pink-300 focus:border-pink-300 @error('title') border-red-500 focus:ring-red-500 @enderror"
                            value="{{ old('title') }}"
                            required>
                        @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-medium text-pink-900 mb-2">Content</label>
                        <textarea
                            name="content"
                            id="content"
                            rows="8"
                            class="w-full px-4 py-2.5 rounded-lg border border-pink-200 focus:ring-2 focus:ring-pink-300 focus:border-pink-300 @error('content') border-red-500 focus:ring-red-500 @enderror"
                            required>{{ old('content') }}</textarea>
                        @error('content')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-pink-900 mb-2">Image</label>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 bg-pink-400 hover:bg-pink-500 text-white px-4 py-2 rounded-lg cursor-pointer transition-colors duration-200">
                                <span class="material-icons text-base">add_a_photo</span>
                                Choose File
                                <input type="file" name="image" class="hidden" onchange="document.getElementById('file-name').textContent = this.files[0]?.name || 'No file chosen';">
                            </label>
                            <span id="file-name" class="text-sm text-gray-500">No file chosen</span>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Allowed file types: JPG, JPEG, PNG, GIF, SVG, WEBP (Max 8MB)</p>
                        @error('image')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-pink-900 mb-2">Tags</label>
                        <div id="tag-selection-container"
                             class="flex flex-wrap gap-2 p-4 bg-pink-50 rounded-lg border border-pink-200 @error('tags') border-red-500 @enderror">
                            @forelse($tags as $tag)
                                <span class="tag-item
                                    bg-white text-pink-700
                                    hover:bg-pink-100
                                    rounded-full px-3 py-1 text-sm font-medium cursor-pointer transition
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
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @error('tags.*')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-4">
                        <button type="submit"
                                class="bg-pink-400 hover:bg-pink-500 text-white px-6 py-2.5 rounded-lg flex items-center gap-2 transition-colors duration-200">
                            <span class="material-icons text-base">add_circle</span>
                            Create Article
                        </button>
                        <a href="{{ route('admin.articles.index') }}"
                           class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg flex items-center gap-2 transition-colors duration-200">
                            <span class="material-icons text-base">close</span>
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tagItems = document.querySelectorAll('.tag-item');
            const hiddenTagsInput = document.getElementById('hidden-tags-input');
            let selectedTagIds = [];

            function applyTagClasses(item, isSelected) {
                if (isSelected) {
                    item.classList.add('selected-tag', 'bg-pink-400', 'text-white');
                    item.classList.remove('bg-white', 'text-pink-700', 'hover:bg-pink-100');
                } else {
                    item.classList.add('bg-white', 'text-pink-700', 'hover:bg-pink-100');
                    item.classList.remove('selected-tag', 'bg-pink-400', 'text-white');
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
        });
    </script>
@endsection

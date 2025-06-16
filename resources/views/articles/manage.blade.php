@extends('layouts.admin')

@section('title', 'Manage Articles')

@section('content')
    <div class="w-full max-w-7xl mx-auto flex flex-col gap-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-theme-900 flex items-center gap-2">
                <span class="material-icons text-theme-400">menu_book</span>
                Manage Articles
            </h1>
            <a href="{{ route('articles.create') }}" class="bg-pink-400 hover:bg-pink-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-200 flex items-center gap-2">
                <span class="material-icons text-base">add_circle</span>
                New Article
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6">
            @forelse ($articles as $article)
                <div class="bg-white rounded-2xl shadow p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex-grow">
                        <h2 class="text-xl font-bold text-theme-900 mb-2">
                            <a href="{{ route('articles.show', $article) }}" class="hover:underline">
                                {{ $article->title }}
                            </a>
                        </h2>
                        <p class="text-theme-700 text-sm">{{ Str::limit($article->content, 30, '...') }}</p>
                    </div>
                    <div class="flex gap-3 items-center flex-shrink-0">
                        <a href="{{ route('articles.edit', $article) }}" class="bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold py-2 px-4 rounded-lg flex items-center gap-2 transition duration-200">
                            <span class="material-icons text-base">edit</span>
                            Edit
                        </a>
                        <button type="button"
                                onclick="window.ModalUtils.openDeleteModal('{{ $article->id }}', '{{ url('articles') }}')"
                                class="bg-red-100 hover:bg-red-200 text-red-700 font-semibold py-2 px-4 rounded-lg flex items-center gap-2 transition duration-200">
                            <span class="material-icons text-base">delete</span>
                            Delete
                        </button>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl shadow p-6 text-center text-theme-700">
                    No articles found.
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $articles->links('pagination::tailwind') }}
        </div>
    </div>

    <x-delete-modal
        title="Delete Article"
        message="Are you sure you want to delete this article? This action cannot be undone."
        confirmText="Yes"
        cancelText="No"
        feature="articles"
    />
@endsection

@push('scripts')
    @vite('resources/js/modal-utils.js')
@endpush

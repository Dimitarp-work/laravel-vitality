@extends('layouts.vitality')

@section('title', $article->title)

@section('content')
    <div class="container">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold text-pink-300">{{ $article->title }}</h1>
            <a href="{{ route('articles.index') }}"
               class="inline-flex items-center gap-2 hover:bg-red-100 bg-white text-gray-400 hover:text-pink-600 font-semibold px-6 py-2 rounded-lg shadow cursor-pointer transition">
                Back to articles <span class="material-icons text-base">redo</span>
            </a>
        </div>

        <div class="flex justify-between items-center mb-4 gap-3">
            <p class="bg-gray-200 rounded-lg shadow px-3 py-2 text-pink-800 focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-300">
                {{ $article->content }}
            </p>
            @if($article->image)
                <img src="{{ asset('storage/' . $article->image) }}"
                     alt="{{ $article->title }}"
                     class="rounded-lg max-h-40 object-contain shadow mt-3">
            @endif
        </div>

        @if($article->tags->isNotEmpty())
            <div class="mt-4">
                <h2 class="text-xl font-semibold text-pink-300 mb-2">Tags:</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($article->tags as $tag)
                        <span class="px-3 py-1 bg-pink-300 text-white text-sm rounded-full shadow">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection

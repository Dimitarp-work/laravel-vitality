@extends('layouts.vitality')

@section('title', $article->title)

@section('content')
    <div class="container">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-3xl font-bold text-pink-300">{{ $article->title }}</h1>
            <a href="#" onclick="history.back(); return false;"
               class="inline-flex items-center gap-2 hover:bg-red-100 bg-white text-gray-400 hover:text-pink-600 font-semibold px-6 py-2 rounded-lg shadow cursor-pointer transition">
                Back <span class="material-icons text-base">redo</span>
            </a>
        </div>
    <div class="w-full pl-0 md:pl-72">
        <div class="max-w-4xl mx-auto px-6 py-8">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
                <h1 class="text-2xl md:text-3xl font-bold text-pink-900 flex items-center gap-2">
                    <span class="material-icons text-pink-400">article</span>
                    {{ $article->title }}
                </h1>
                <a href="{{ route('articles.index') }}"
                   class="bg-pink-400 hover:bg-pink-500 text-white px-3 py-1.5 rounded-lg self-start sm:self-auto flex items-center gap-1 whitespace-nowrap transition-colors duration-200">
                    <span class="material-icons text-base">arrow_back</span>
                    Back to articles
                </a>
            </div>

            <!-- Article Content -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <div class="prose prose-pink max-w-none">
                    {!! $article->content !!}
                </div>

                @if($article->image)
                    <div class="mt-8">
                        <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}"
                             class="rounded-lg w-full max-h-96 object-contain shadow">
                    </div>
                @endif

                @if($article->tags->isNotEmpty())
                    <div class="mt-8 pt-6 border-t border-pink-100">
                        <h2 class="text-lg font-semibold text-pink-900 mb-4">Tags</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach($article->tags as $tag)
                                <span class="px-3 py-1 bg-pink-100 text-pink-700 text-sm rounded-full shadow">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mt-8 pt-6 border-t border-pink-100 text-sm text-gray-500">
                    Published on {{ $article->published_at ?? $article->created_at->format('F j, Y') }}
                </div>
            </div>
        </div>
    </div>
@endsection

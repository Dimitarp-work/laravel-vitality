@extends('layouts.vitality')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-pink-300">
                Wellness Inspiration
            </h1>
            <a href="{{ route('articles.create') }}"
               class="hover:bg-gray-300 bg-white hover:text-black text-gray-500 font-semibold px-6 py-2 rounded-lg shadow">
                Create Article
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Filter by Tag --}}
        <div class="mb-6">
            <form method="GET">
                <label class="text-pink-300 font-semibold mb-2 block">Filter by Tag:</label>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('articles.index') }}"
                       class="px-4 py-2 rounded-lg shadow
                    {{ request('tag') ? 'bg-gray-100 text-gray-500 hover:bg-gray-200' : 'bg-pink-300 text-white' }}">
                        All
                    </a>
                    @foreach($tags as $tag)
                        <a href="{{ route('articles.index', ['tag' => $tag->id]) }}"
                           class="px-4 py-2 rounded-lg shadow cursor-pointer
                        {{ request('tag') == $tag->id ? 'bg-pink-300 text-white' : 'bg-gray-100 text-gray-500 hover:bg-gray-200 hover:text-black' }}">
                            {{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            </form>
        </div>

        {{-- Articles + Trending Layout --}}
        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Articles Section --}}
            <div class="w-full lg:w-2/3">
                <div class="inline-grid grid-cols-2 auto-cols-max gap-3">
                    @foreach($articles as $article)
                        <div class="col-span-1 bg-white rounded-2xl shadow-lg p-6 w-full max-w-[300px]">
                            <div class="flex flex-col gap-1">
                                <a href="{{ route('articles.show', $article) }}"
                                   class="text-2xl font-semibold text-pink-300 hover:text-pink-700">
                                    {{ $article->title }}
                                </a>
                                <p class="text-gray-500 text-sm">
                                    {{ $article->published_at ?? $article->created_at->format('F j, Y') }}
                                </p>
                                <div class="text-gray-600 text-sm line-clamp-3">
                                    {{ Str::limit(strip_tags($article->content), 50) }}
                                </div>

                                @if($article->image)
                                    <img src="{{ asset('storage/' . $article->image) }}"
                                         alt="{{ $article->title }}"
                                         class="rounded-lg w-full max-h-40 object-contain shadow mt-3">
                                @endif

                                @if($article->tags->isNotEmpty())
                                    <div class="flex flex-wrap gap-2 mt-3">
                                        @foreach($article->tags as $tag)
                                            <span class="px-3 py-1 bg-pink-300 text-white text-xs rounded-full shadow">
                                                {{ $tag->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="flex justify-between mt-4">
                                    <a href="{{ route('articles.edit', $article) }}"
                                       class="px-4 py-2 bg-blue-100 text-blue-400 rounded-lg hover:bg-blue-200 transition font-medium hover:text-blue-900">
                                        Edit
                                    </a>
                                    <form action="{{ route('articles.destroy', $article->id) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this article?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-4 py-2 bg-pink-100 hover:text-pink-700 text-pink-400 rounded-lg hover:bg-pink-200 transition font-medium cursor-pointer">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Trending Sidebar --}}
            @if($trendingArticles->count() || $allTrendingArticles->count())
                <div class="w-full lg:w-1/3 space-y-6">
                    {{-- Trending This Week --}}
                    @if($trendingArticles->count())
                        <div class="bg-gray-100 border border-pink-200 rounded-lg p-4 shadow">
                            <h2 class="text-pink-400 text-lg font-bold mb-3">Trending This Week</h2>
                            <div class="space-y-3">
                                @foreach($trendingArticles as $trending)
                                    <a href="{{ route('articles.show', $trending) }}"
                                       class="flex items-center gap-3 hover:bg-pink-200 transition px-3 py-2 rounded-md">
                                        @if($trending->image)
                                            <img src="{{ asset('storage/' . $trending->image) }}"
                                                 alt="{{ $trending->title }}"
                                                 class="w-12 h-12 object-cover rounded-md shadow">
                                        @else
                                            <div
                                                class="w-12 h-12 bg-gray-200 rounded-md flex items-center justify-center text-gray-400 text-sm">
                                                N/A
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-sm font-semibold text-pink-600 line-clamp-1">{{ $trending->title }}</p>
                                            <p class="text-xs text-gray-400">{{ $trending->views }} views</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- All-Time Trending --}}
                    @if($allTrendingArticles->count())
                        <div class="bg-gray-100 border border-yellow-300 rounded-lg p-4 shadow">
                            <h2 class="text-yellow-500 text-lg font-bold mb-3">All-Time Trending</h2>
                            <div class="space-y-3">
                                @foreach($allTrendingArticles as $trending)
                                    <a href="{{ route('articles.show', $trending) }}"
                                       class="flex items-center gap-3 hover:bg-yellow-200 transition px-3 py-2 rounded-md">
                                        @if($trending->image)
                                            <img src="{{ asset('storage/' . $trending->image) }}"
                                                 alt="{{ $trending->title }}"
                                                 class="w-12 h-12 object-cover rounded-md shadow">
                                        @else
                                            <div
                                                class="w-12 h-12 bg-gray-200 rounded-md flex items-center justify-center text-gray-400 text-sm">
                                                N/A
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-sm font-semibold text-yellow-600 line-clamp-1">{{ $trending->title }}</p>
                                            <p class="text-xs text-gray-400">{{ $trending->views }} views</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
@endsection

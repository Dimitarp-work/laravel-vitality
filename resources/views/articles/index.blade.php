@extends('layouts.vitality')

@section('content')
    <div class="w-full pl-0 md:pl-72">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-pink-900 flex items-center gap-2">
                    <span class="material-icons text-pink-400">article</span>
                    Wellness Inspiration
                </h1>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-8">
                <form method="GET">
                    <label class="text-pink-700 font-semibold mb-2 block">Filter by Tag:</label>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('articles.index') }}"
                           class="px-4 py-2 rounded-lg shadow transition-all duration-200
                        {{ request('tag') ? 'bg-gray-100 text-gray-500 hover:bg-gray-200' : 'bg-pink-400 text-white hover:bg-pink-500' }}">
                            All
                        </a>
                        @foreach($tags as $tag)
                            <a href="{{ route('articles.index', ['tag' => $tag->id]) }}"
                               class="px-4 py-2 rounded-lg shadow cursor-pointer transition-all duration-200
                            {{ request('tag') == $tag->id ? 'bg-pink-400 text-white' : 'bg-gray-100 text-gray-500 hover:bg-gray-200 hover:text-black' }}">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                </form>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <div class="w-full lg:w-3/4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 justify-items-center">
                        @forelse($articles as $article)
                            <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-[500px] hover:shadow-xl transition-shadow duration-200">
                                <div class="flex flex-col gap-2">
                                    <a href="{{ route('articles.show', $article) }}"
                                       class="text-2xl font-semibold text-pink-900 hover:text-pink-700 transition-colors duration-200">
                                        {{ $article->title }}
                                    </a>
                                    <p class="text-gray-500 text-sm">
                                        {{ $article->published_at ?? $article->created_at->format('F j, Y') }}
                                    </p>
                                    <div class="text-gray-600 text-sm line-clamp-3">
                                        {{ Str::limit(strip_tags($article->content), 120) }}
                                    </div>

                                    @if($article->image)
                                        <img src="{{ asset('storage/' . $article->image) }}"
                                             alt="{{ $article->title }}"
                                             class="rounded-lg w-full max-h-48 object-contain shadow mt-4">
                                    @endif

                                    @if($article->tags->isNotEmpty())
                                        <div class="flex flex-wrap gap-2 mt-4">
                                            @foreach($article->tags as $tag)
                                                <span class="px-3 py-1 bg-pink-100 text-pink-700 text-xs rounded-full shadow">
                                                    {{ $tag->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center text-gray-500 text-lg my-8 w-full">
                                <span class="material-icons text-4xl text-pink-300 mb-2">article</span>
                                <p>No articles found.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                @if($trendingArticles->count() || $allTrendingArticles->count())
                    <div class="w-full lg:w-1/4 space-y-6">
                        @if($trendingArticles->count())
                            <div class="bg-white border border-pink-200 rounded-lg p-4 shadow">
                                <h2 class="text-pink-900 text-lg font-bold mb-3 flex items-center gap-2">
                                    <span class="material-icons text-pink-400">trending_up</span>
                                    Newest and Most Popular
                                </h2>
                                <div class="space-y-3">
                                    @foreach($trendingArticles as $trending)
                                        <a href="{{ route('articles.show', $trending) }}"
                                           class="flex items-center gap-3 hover:bg-pink-50 transition-all duration-200 px-3 py-2 rounded-md">
                                            @if($trending->image)
                                                <img src="{{ asset('storage/' . $trending->image) }}"
                                                     alt="{{ $trending->title }}"
                                                     class="w-12 h-12 object-cover rounded-md shadow">
                                            @else
                                                <div class="w-12 h-12 bg-pink-100 rounded-md flex items-center justify-center text-pink-400">
                                                    <span class="material-icons">article</span>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="text-sm font-semibold text-pink-900 line-clamp-1">{{ $trending->title }}</p>
                                                <p class="text-xs text-pink-600">{{ $trending->views }} views</p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($allTrendingArticles->count())
                            <div class="bg-white border border-pink-200 rounded-lg p-4 shadow">
                                <h2 class="text-pink-900 text-lg font-bold mb-3 flex items-center gap-2">
                                    <span class="material-icons text-pink-400">star</span>
                                    All-Time Popular
                                </h2>
                                <div class="space-y-3">
                                    @foreach($allTrendingArticles as $trending)
                                        <a href="{{ route('articles.show', $trending) }}"
                                           class="flex items-center gap-3 hover:bg-pink-50 transition-all duration-200 px-3 py-2 rounded-md">
                                            @if($trending->image)
                                                <img src="{{ asset('storage/' . $trending->image) }}"
                                                     alt="{{ $trending->title }}"
                                                     class="w-12 h-12 object-cover rounded-md shadow">
                                            @else
                                                <div class="w-12 h-12 bg-pink-100 rounded-md flex items-center justify-center text-pink-400">
                                                    <span class="material-icons">article</span>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="text-sm font-semibold text-pink-900 line-clamp-1">{{ $trending->title }}</p>
                                                <p class="text-xs text-pink-600">{{ $trending->views }} views</p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

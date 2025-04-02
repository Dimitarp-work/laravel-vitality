@extends('layouts.app')

@section('title', 'Articles')

@section('content')
<div class="container">
    <h1>Articles</h1>
    @foreach($articles as $article)
        <div class="card mb-3">
            <div class="card-body">
                <h2><a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a></h2>
                <p>{{ Str::limit($article->content, 100) }}</p>
            </div>
        </div>
    @endforeach
</div>
@endsection

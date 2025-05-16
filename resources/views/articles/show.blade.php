@extends('layouts.app')

@section('title', $article->title)

@section('content')
<div class="container">
    <h1>{{ $article->title }}</h1>
    <p>{{ $article->content }}</p>
    <a href="{{ route('articles.index') }}">Back to articles</a>
</div>
@endsection

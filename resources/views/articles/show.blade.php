@extends('layout')

@section('title', $article->title)

@section('content')
    <h1>{{ $article->title }}</h1>

    @if (session('status'))
        <p role="status">{{ session('status') }}</p>
    @endif

    <p>{{ $article->created_at?->format('d.m.Y') }}</p>
    <p>{{ $article->summary }}</p>
    <a href="{{ route('galery', ['full_image' => $article->full_image]) }}">
        <img src="/{{ $article->preview_image }}" alt="{{ $article->title }}" width="150">
    </a>
    <p class="article-body">{{ $article->content }}</p>

    <p><a href="{{ route('articles.edit', $article) }}">Редактировать</a></p>
    <p><a href="{{ route('articles.index') }}">К списку статей</a></p>
@endsection

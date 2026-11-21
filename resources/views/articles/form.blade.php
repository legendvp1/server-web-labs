@extends('layout')

@php
    $editing = $article->exists;
    $heading = $editing ? 'Редактирование статьи' : 'Новая статья';
    $action = $editing ? route('articles.update', $article) : route('articles.store');
    $title = old('title', $article->title);
    $summary = old('summary', $article->summary);
    $content = old('content', $article->content);
    $selectedImage = old('full_image', $article->full_image ?? array_key_first($images));
@endphp

@section('title', $heading)

@section('content')
    <h1>{{ $heading }}</h1>

    @if ($errors->any())
        <ul role="alert">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form class="article-form" action="{{ $action }}" method="post">
        @csrf
        @if ($editing)
            @method('PUT')
        @endif

        <p>
            <label for="title">Название</label>
            <input type="text" id="title" name="title" value="{{ is_string($title) ? $title : '' }}" maxlength="255" required>
        </p>
        <p>
            <label for="summary">Краткое описание</label>
            <textarea id="summary" name="summary" rows="3" maxlength="500" required>{{ is_string($summary) ? $summary : '' }}</textarea>
        </p>
        <p>
            <label for="content">Текст статьи</label>
            <textarea id="content" name="content" rows="7" maxlength="10000" required>{{ is_string($content) ? $content : '' }}</textarea>
        </p>

        <fieldset>
            <legend>Изображение</legend>
            <div class="article-images">
                @foreach ($images as $fullImage => $previewImage)
                    <label>
                        <input type="radio" name="full_image" value="{{ $fullImage }}" @checked($selectedImage === $fullImage) required>
                        <img src="/{{ $previewImage }}" alt="" width="72">
                        Фото {{ $loop->iteration }}
                    </label>
                @endforeach
            </div>
        </fieldset>

        <p>
            <button type="submit">Сохранить</button>
            <a href="{{ route('articles.index') }}">К списку статей</a>
        </p>
    </form>
@endsection

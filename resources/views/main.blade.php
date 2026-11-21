@extends('layout')

@section('title', 'Главная')

@section('content')
    <h1>Новости</h1>

    @if (session('status'))
        <p role="status">{{ session('status') }}</p>
    @endif

    @auth
        <p><a href="{{ route('articles.create') }}">Добавить статью</a></p>
    @endauth

    <div class="article-table">
        <table>
            <thead>
                <tr>
                    <th scope="col">Дата</th>
                    <th scope="col">Название</th>
                    <th scope="col">Картинка</th>
                    <th scope="col">Краткое описание</th>
                    <th scope="col">Описание</th>
                    @auth
                        <th scope="col">Действия</th>
                    @endauth
                </tr>
            </thead>
            <tbody>
                @forelse ($articles as $article)
                    <tr>
                        <td>{{ $article->created_at?->format('d.m.Y') }}</td>
                        <td><a href="{{ route('articles.show', $article) }}">{{ $article->title }}</a></td>
                        <td>
                            <a href="{{ route('galery', ['full_image' => $article->full_image]) }}">
                                <img src="/{{ $article->preview_image }}" alt="{{ $article->title }}" width="150">
                            </a>
                        </td>
                        <td>{{ $article->summary }}</td>
                        <td>{{ $article->content }}</td>
                        @auth
                            <td class="article-actions">
                                <a href="{{ route('articles.edit', $article) }}">Редактировать</a>
                                <form action="{{ route('articles.destroy', $article) }}" method="post" onsubmit="return confirm('Удалить статью?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" aria-label="Удалить статью «{{ $article->title }}»">Удалить</button>
                                </form>
                            </td>
                        @endauth
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->check() ? 6 : 5 }}">На этой странице нет статей.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($articles->hasPages())
        <nav class="pagination" aria-label="Страницы новостей">
            @if ($articles->previousPageUrl())
                <a href="{{ $articles->previousPageUrl() }}" rel="prev">Назад</a>
            @endif

            <span>Страница {{ $articles->currentPage() }} из {{ $articles->lastPage() }}</span>

            @if ($articles->nextPageUrl())
                <a href="{{ $articles->nextPageUrl() }}" rel="next">Вперёд</a>
            @endif
        </nav>
    @endif
@endsection

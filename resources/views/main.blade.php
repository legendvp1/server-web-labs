@extends('layout')

@section('title', 'Главная')

@section('content')
    <h1>Новости</h1>

    <table>
        <tr>
            <th>Дата</th>
            <th>Название</th>
            <th>Картинка</th>
            <th>Краткое описание</th>
            <th>Описание</th>
        </tr>
        @forelse ($articles as $article)
            <tr>
                <td>{{ $article->created_at?->format('d.m.Y') }}</td>
                <td>{{ $article->title }}</td>
                <td>
                    <a href="{{ route('galery', ['full_image' => $article->full_image]) }}">
                        <img src="/{{ $article->preview_image }}" alt="{{ $article->title }}" width="150">
                    </a>
                </td>
                <td>{{ $article->summary }}</td>
                <td>{{ $article->content }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5">Пока нет статей.</td>
            </tr>
        @endforelse
    </table>
@endsection

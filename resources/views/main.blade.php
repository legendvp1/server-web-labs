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
        @foreach ($articles as $article)
            <tr>
                <td>{{ $article['Дата'] }}</td>
                <td>{{ $article['Название'] }}</td>
                <td>
                    <a href="/galery/{{ $article['full_image'] }}">
                        <img src="/{{ $article['preview_image'] }}" alt="{{ $article['Название'] }}" width="150">
                    </a>
                </td>
                <td>{{ $article['Краткое описание'] }}</td>
                <td>{{ $article['Описание'] }}</td>
            </tr>
        @endforeach
    </table>
@endsection

@extends('layout')

@section('title', 'Галерея')

@section('content')
    <h1>Галерея</h1>

    <img src="/{{ $full_image }}" alt="Полная картинка" width="100%">

    <p><a href="/">Назад к новостям</a></p>
@endsection

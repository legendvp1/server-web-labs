@extends('layout')

@section('title', 'Вход')

@section('content')
    @php
        $email = old('email');
    @endphp

    <h1>Вход</h1>

    @if (session('status'))
        <p role="status">{{ session('status') }}</p>
    @endif

    @if ($errors->any())
        <ul role="alert">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('login.authenticate') }}" method="post">
        @csrf

        <p>
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" value="{{ is_string($email) ? $email : '' }}" autocomplete="username" maxlength="255" required>
        </p>

        <p>
            <label for="password">Пароль</label><br>
            <input type="password" id="password" name="password" autocomplete="current-password" maxlength="72" required>
        </p>

        <button type="submit">Войти</button>
    </form>

    <p><a href="{{ route('signin') }}">Зарегистрироваться</a></p>
@endsection

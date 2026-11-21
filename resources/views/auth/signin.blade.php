@extends('layout')

@section('title', 'Регистрация')

@section('content')
    @php
        $name = old('name');
        $email = old('email');
    @endphp

    <h1>Регистрация</h1>

    @if ($errors->any())
        <ul role="alert">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('signin.registration') }}" method="post">
        @csrf

        <p>
            <label for="name">Имя</label><br>
            <input type="text" id="name" name="name" value="{{ is_string($name) ? $name : '' }}" autocomplete="name" maxlength="255" required>
        </p>

        <p>
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" value="{{ is_string($email) ? $email : '' }}" autocomplete="email" maxlength="255" required>
        </p>

        <p>
            <label for="password">Пароль</label><br>
            <input type="password" id="password" name="password" autocomplete="new-password" minlength="8" maxlength="72" required>
        </p>

        <button type="submit">Зарегистрироваться</button>
    </form>

    <p><a href="{{ route('login') }}">Войти в аккаунт</a></p>
@endsection

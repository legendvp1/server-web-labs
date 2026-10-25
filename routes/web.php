<?php

use Illuminate\Support\Facades\Route;

// Главная страница - приветствие
Route::get('/', function () {
    return view('main');
});

// Страница "О нас"
Route::get('/about', function () {
    return view('about');
});

// Страница "Контакты" - передаем массив данных в шаблон через view
Route::get('/contacts', function () {
    $contacts = [
        ['name' => 'Телефон', 'value' => '+7 (495) 223-05-23'],
        ['name' => 'Email', 'value' => 'mospolytech@mospolytech.ru'],
    ];

    return view('contacts', ['contacts' => $contacts]);
});

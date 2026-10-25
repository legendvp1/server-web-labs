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
        ['name' => 'Телефон', 'value' => '+7 (999) 123-45-67'],
        ['name' => 'Email', 'value' => 'info@mysite.ru'],
        ['name' => 'Адрес', 'value' => 'г. Москва, ул. Большая Семёновская, д. 38'],
        ['name' => 'Время работы', 'value' => 'Пн-Пт с 9:00 до 18:00'],
    ];

    return view('contacts', ['contacts' => $contacts]);
});

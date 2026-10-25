<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

// Главная страница - вызываем метод index контроллера MainController
Route::get('/', [MainController::class, 'index']);

// Страница galery - показываем полную картинку
Route::get('/galery/{full_image}', [MainController::class, 'galery']);

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

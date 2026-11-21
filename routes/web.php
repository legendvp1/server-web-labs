<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ArticleController::class, 'index'])->name('articles.index');
Route::resource('articles', ArticleController::class)->except(['index']);

// Страница galery - показываем полную картинку
Route::get('/galery/{full_image}', [MainController::class, 'galery'])->name('galery');

Route::get('/signin', [AuthController::class, 'create'])->name('signin');
Route::post('/signin', [AuthController::class, 'registration'])->name('signin.registration');

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

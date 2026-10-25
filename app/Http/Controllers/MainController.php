<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    // Главная страница: читаем данные из json-файла и отправляем их в шаблон
    public function index()
    {
        // Читаем файл articles.json из папки public
        $json = file_get_contents(public_path('articles.json'));

        // Превращаем json-строку в массив (true - чтобы получился обычный массив)
        $articles = json_decode($json, true);

        return view('main', ['articles' => $articles]);
    }

    // Страница galery: показываем полную картинку
    public function galery($full_image)
    {
        return view('galery', ['full_image' => $full_image]);
    }
}

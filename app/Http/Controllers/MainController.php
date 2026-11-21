<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class MainController extends Controller
{
    public function galery(string $full_image): View
    {
        return view('galery', ['full_image' => $full_image]);
    }
}

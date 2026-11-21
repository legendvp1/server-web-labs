<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function create(): View
    {
        return view('auth.signin');
    }

    public function registration(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ], [
            'name.required' => 'Введите имя.',
            'name.string' => 'Введите имя текстом.',
            'name.max' => 'Имя должно содержать не больше 255 символов.',
            'email.required' => 'Введите email.',
            'email.email' => 'Введите корректный email.',
            'email.max' => 'Email должен содержать не больше 255 символов.',
            'password.required' => 'Введите пароль.',
            'password.string' => 'Введите пароль текстом.',
            'password.min' => 'Пароль должен содержать не меньше 8 символов.',
        ]);

        return response()->json([
            'name' => $data['name'],
            'email' => $data['email'],
        ], options: JSON_UNESCAPED_UNICODE);
    }
}

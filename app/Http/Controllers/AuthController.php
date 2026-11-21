<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    private const PASSWORD_BYTES = 'regex:/\A[^\x00]{1,72}\z/';

    public function create(): View
    {
        return view('auth.signin');
    }

    public function registration(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'bail|required|email|max:255|unique:users,email',
            'password' => ['bail', 'required', 'string', 'min:8', self::PASSWORD_BYTES],
        ], [
            'name.required' => 'Введите имя.',
            'name.string' => 'Введите имя текстом.',
            'name.max' => 'Имя должно содержать не больше 255 символов.',
            'email.required' => 'Введите email.',
            'email.email' => 'Введите корректный email.',
            'email.max' => 'Email должен содержать не больше 255 символов.',
            'email.unique' => 'Этот email уже зарегистрирован.',
            'password.required' => 'Введите пароль.',
            'password.string' => 'Введите пароль текстом.',
            'password.min' => 'Пароль должен содержать не меньше 8 символов.',
            'password.regex' => 'Используйте пароль длиной до 72 байт без нулевых символов.',
        ]);

        try {
            User::create($data);
        } catch (UniqueConstraintViolationException) {
            throw ValidationException::withMessages(['email' => 'Этот email уже зарегистрирован.']);
        }

        return redirect()->route('login')->with('status', 'Регистрация завершена. Теперь можно войти.');
    }

    public function loginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'bail|required|email|max:255',
            'password' => ['bail', 'required', 'string', self::PASSWORD_BYTES],
        ], [
            'email.required' => 'Введите email.',
            'email.email' => 'Введите корректный email.',
            'email.max' => 'Email должен содержать не больше 255 символов.',
            'password.required' => 'Введите пароль.',
            'password.string' => 'Введите пароль текстом.',
            'password.regex' => 'Введите корректный пароль.',
        ]);

        $loggedIn = Auth::guard('web')->attemptWhen($credentials, function (User $user) use ($request): bool {
            $token = $user->createToken('web-session', ['*'], now()->addMinutes((int) config('session.lifetime')));
            $request->session()->put('sanctum_token_id', $token->accessToken->id);

            return true;
        });

        if (! $loggedIn) {
            throw ValidationException::withMessages(['email' => 'Неверный email или пароль.']);
        }

        $request->session()->regenerate();

        return redirect()->route('articles.index');
    }

    public function logout(Request $request): RedirectResponse
    {
        $user = $request->user();
        $token = $user->currentAccessToken();

        if ($token instanceof PersonalAccessToken) {
            $token->delete();
        } else {
            $user->tokens()->whereKey($request->session()->get('sanctum_token_id'))->delete();
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('articles.index');
    }
}

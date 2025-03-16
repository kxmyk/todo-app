<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $this->authService->register($request->validated());

        return redirect()->route('login')->with('success', 'Konto zostało utworzone. Możesz się teraz zalogować.');
    }

    public function login(LoginRequest $request): JsonResponse|RedirectResponse
    {
        $token = $this->authService->login($request->validated());

        if (!$token) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Nieprawidłowe dane logowania.'], 401);
            }
            return back()->withErrors(['email' => 'Nieprawidłowe dane logowania.']);
        }

        if ($request->expectsJson()) {
            return response()->json(['token' => $token, 'message' => 'Zalogowano pomyślnie']);
        }

        return redirect()->route('tasks.index')->with('auth_token', $token);
    }

    public function logout(): RedirectResponse
    {
        $this->authService->logout();
        return redirect()->route('login');
    }
}
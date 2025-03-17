<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Strona główna – przekierowanie w zależności od zalogowania
Route::get('/', function () {
    return auth()->check() ? redirect()->route('tasks.index') : redirect()->route('login');
});

// Widoki logowania i rejestracji
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

// API logowania i rejestracji
Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

// Middleware `auth:sanctum` dla zabezpieczenia zadań
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');

    Route::apiResource('tasks', TaskController::class)->except(['create', 'edit']);

    Route::post('/tasks/{task}/generate-access-token', [TaskController::class, 'generateAccessToken'])
        ->name('api.tasks.generate-token');

    Route::get('/user', fn() => response()->json(auth()->user()))->name('api.user');

    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
});

// Udostępnianie zadań przez token (bez logowania)
Route::get('/tasks/shared/{token}', [TaskController::class, 'showByToken'])->name('api.tasks.shared');

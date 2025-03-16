<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::get('/user', fn() => response()->json(request()->user()));
    Route::apiResource('tasks', TaskController::class);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Task token generation
    Route::post('/tasks/{task}/generate-token', [TaskController::class, 'generateAccessToken']);
});

// Shared task access
Route::get('/tasks/shared/{token}', [TaskController::class, 'showByToken']);

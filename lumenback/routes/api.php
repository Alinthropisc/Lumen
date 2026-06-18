<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

// Auth routes
Route::prefix('auth')->group(function () {
    // Public routes with rate limiting
    Route::middleware('throttle:10,1')->group(function () {
        Route::post('/send-code', [AuthController::class, 'sendCode'])->name('auth.send-code');
    });

    Route::middleware('throttle:5,1')->group(function () {
        Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
        Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
        Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('auth.reset-password');
    });

    // Protected routes
    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::get('/check-token', [AuthController::class, 'checkUserToken'])->name('auth.check-token');
        Route::put('/update-yourself', [AuthController::class, 'updateYourself'])->name('auth.update-yourself');
    });
});

// User CRUD routes (protected)
Route::middleware('auth:api')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::get('/users-roles', [UserController::class, 'roles'])->name('users.roles');
});

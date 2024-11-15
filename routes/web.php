<?php

use App\Http\Controllers\AuthController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        Artisan::call('app:delete-verify-code');
    }
    return view('layouts.main');
});
// Auth
Route::get('/login', [AuthController::class, 'loginPage']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'registerPage']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/registerVerify', [AuthController::class, 'registerVerify']);
Route::post('/verify', [AuthController::class, 'verify']);


// Users
Route::middleware(['App\Http\Middleware\Check'])->group(function () {
    Route::resource('/users', UserController::class);
});

Route::get('/profile', [ProfileController::class, 'index']);
Route::get('/editPassword', [ProfileController::class, 'edit']);


<?php

use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Route;

// Auth Page
Route::get('/auth/login', [Auth::class, 'loginPage']);
Route::get('/auth/register', [Auth::class, 'registerPage']);
// Auth Method
Route::post('/auth/login', [Auth::class, 'login'])->name('login');
Route::post('/auth/register', [Auth::class, 'register'])->name('register');
// Logout Method
Route::post('/auth/logout', [Auth::class, 'logout'])->name('logout');

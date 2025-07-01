<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('pages.client.dashboard');
})->middleware(['auth'])->name('dashboard');

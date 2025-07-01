<?php

use App\Http\Middleware\AdminOnly;
use Illuminate\Support\Facades\Route;

Route::get('/admin', function () {
    return view('pages.admin.index');
})->middleware(['auth', AdminOnly::class])->name('admin-dashboard');

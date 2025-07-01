<?php

use App\Http\Controllers\AdminDashboard;
use App\Http\Controllers\Grup;
use App\Http\Controllers\User;
use App\Http\Middleware\AdminOnly;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', AdminOnly::class])->group(function () {
    Route::get('/admin', [AdminDashboard::class, 'index'])->name('admin-dashboard');
    Route::resource('/admin/data-user', User::class)->names('data-akun');
    Route::resource('/admin/grup/data-grup', Grup::class)->names('data-anggota');
});

<?php

use App\Http\Controllers\AdminDashboard;
use App\Http\Controllers\Anggota;
use App\Http\Controllers\CicilanPinjaman;
use App\Http\Controllers\Grup;
use App\Http\Controllers\LaporanPinjaman;
use App\Http\Controllers\NamaStatus;
use App\Http\Controllers\Pendanaan;
use App\Http\Controllers\Pinjaman;
use App\Http\Controllers\RiwayatCicilan;
use App\Http\Controllers\SukuBunga;
use App\Http\Controllers\User;
use App\Http\Middleware\AdminOnly;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', AdminOnly::class])->group(function () {
    Route::get('admin', [AdminDashboard::class, 'index'])->name('admin-dashboard');
    Route::resource('admin/' . User::$routeName, User::class)->names(User::$routeName);
    Route::resource('admin/' . Grup::$routeName, Grup::class)->names(Grup::$routeName);
    Route::resource('admin/' . Anggota::$routeName, Anggota::class)->names(Anggota::$routeName);
    Route::resource('admin/' . Pendanaan::$routeName, Pendanaan::class)->names(Pendanaan::$routeName);
    Route::resource('admin/' . Pinjaman::$routeName, Pinjaman::class)->names(Pinjaman::$routeName);
    Route::resource('admin/' . CicilanPinjaman::$routeName, CicilanPinjaman::class)->names(CicilanPinjaman::$routeName);
    Route::resource('admin/' . LaporanPinjaman::$routeName, LaporanPinjaman::class)->names(LaporanPinjaman::$routeName);
    Route::resource('admin/' . RiwayatCicilan::$routeName, RiwayatCicilan::class)->names(RiwayatCicilan::$routeName);
    Route::resource('admin/' . NamaStatus::$routeName, NamaStatus::class)->names(NamaStatus::$routeName);
    Route::resource('admin/' . SukuBunga::$routeName, SukuBunga::class)->names(SukuBunga::$routeName);
});

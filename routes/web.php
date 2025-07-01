<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('pages.welcome');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/client.php';

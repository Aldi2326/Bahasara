<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KontakController;

Route::resource('kontak', KontakController::class);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/peta', function () {
    return view('pages.peta');
});



Route::get('/tentang-kami', function () {
    return view('pages.tentang-kami');
});
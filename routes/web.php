<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/peta', function () {
    return view('pages.peta');
});

Route::get('/kontak', function () {
    return view('pages.kontak');
});

Route::get('/tentang-kami', function () {
    return view('pages.tentang-kami');
});
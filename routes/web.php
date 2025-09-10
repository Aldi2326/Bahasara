<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KontakController;

Route::resource('kontak', KontakController::class);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('pages.peta');
});



Route::get('/tentang-kami', function () {
    return view('pages.tentang-kami');
});

Route::get('/admin/dashboard', function () {
    return view('pages.admin.dashboard.index');
});

Route::get('/admin/pesan', function () {
    return view('pages.admin.pesan.index');
});

Route::get('/admin/peta/bahasa', function () {
    return view('pages.admin.peta.bahasa.index');
});
Route::get('/admin/peta/bahasa/tambah', function () {
    return view('pages.admin.peta.bahasa.create');
});

Route::get('/admin/peta/sastra', function () {
    return view('pages.admin.peta.sastra.index');
});

Route::get('/admin/peta/sastra/tambah', function () {
    return view('pages.admin.peta.sastra.create');
});

Route::get('/admin/peta/aksara', function () {
    return view('pages.admin.peta.aksara.index');
});

Route::get('/admin/peta/aksara/tambah', function () {
    return view('pages.admin.peta.aksara.create');
});


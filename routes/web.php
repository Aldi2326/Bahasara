<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KontakController;

// Route::resource('kontak', KontakController::class);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('pages.peta');
});

Route::get('/tentang-kami', function () {
    return view('pages.tentang-kami');
});

Route::get('/kontak', function () {
    return view('pages.kontak');
});

Route::get('/kontak', function () {
    return view('pages.kontak');
});

Route::post('/kontak', [KontakController::class, 'store'])->name('kontak.store');

Route::get('/admin/dashboard', function () {
    return view('pages.admin.dashboard.index');
});

Route::get('/admin/pesan', [KontakController::class, 'index'])->name('kontak.index');
Route::delete('/kontak/{id}', [KontakController::class, 'destroy'])->name('kontak.destroy');

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


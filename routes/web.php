<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\PetaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\BahasaController;

// Route::resource('kontak', KontakController::class);

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('pages.peta');
// });
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/admin/login', [AuthController::class, 'login'])->name('login');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('logout');

// Bungkus beberapa route dengan middleware auth
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('pages.admin.dashboard.index');
    });
    Route::resource('/admin/wilayah', WilayahController::class);
    Route::resource('/admin/peta/bahasa', BahasaController::class);

    // Bahasa


    Route::get('/admin/pesan', [KontakController::class, 'index'])->name('kontak.index');
    Route::delete('/kontak/{id}', [KontakController::class, 'destroy'])->name('kontak.destroy');

    Route::get('/admin/peta/sastra', function () {
        return view('pages.admin.peta.sastra.index');
    });

    Route::get('/admin/peta/sastra/tambah', function () {
        return view('pages.admin.peta.sastra.create');
    });

    Route::get('/admin/peta/sastra/edit', function () {
        return view('pages.admin.peta.sastra.edit');
    });

    Route::get('/admin/peta/aksara', function () {
        return view('pages.admin.peta.aksara.index');
    });

    Route::get('/admin/peta/aksara/tambah', function () {
        return view('pages.admin.peta.aksara.create');
    })->name('aksara.create');

    Route::get('/admin/peta/aksara/edit', function () {
        return view('pages.admin.peta.aksara.edit');
    })->name('aksara.edit');
});

Route::get('/', [PetaController::class, 'index']);
Route::get('/peta/{id}', [PetaController::class, 'show'])->name('peta.show');

Route::get('/sastra', [PetaController::class, 'sastra']);
Route::get('/aksara', [PetaController::class, 'aksara']);


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
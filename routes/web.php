<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\PetaController;

// Route::resource('kontak', KontakController::class);

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('pages.peta');
// });
Route::get('/admin/login', function () {
    return view('pages.admin.login');
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

Route::get('/admin/dashboard', function () {
    return view('pages.admin.dashboard.index');
});

Route::get('/admin/wilayah', function () {
    return view('pages.admin.wilayah.index');
});

Route::get('/admin/wilayah/tambah', function () {
    return view('pages.admin.wilayah.create');
});

Route::get('/admin/wilayah/edit', function () {
    return view('pages.admin.wilayah.edit');
});

Route::get('/admin/pesan', [KontakController::class, 'index'])->name('kontak.index');
Route::delete('/kontak/{id}', [KontakController::class, 'destroy'])->name('kontak.destroy');

Route::get('/admin/peta/bahasa', function () {
    return view('pages.admin.peta.bahasa.index');
});
Route::get('/admin/peta/bahasa/tambah', function () {
    return view('pages.admin.peta.bahasa.create');
})->name('bahasa.create');

Route::get('/admin/peta/bahasa/edit', function () {
    return view('pages.admin.peta.bahasa.edit');
})->name('bahasa.edit');

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


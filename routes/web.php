<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\BahasaController;
use App\Http\Controllers\AksaraController;
use App\Http\Controllers\SastraController;
use App\Http\Controllers\PetaController;
use App\Http\Controllers\PetaAksaraController;
use App\Http\Controllers\PetaSastraController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\TentangKamiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NamaAksaraController;
use App\Http\Controllers\NamaBahasaController;
use App\Http\Controllers\NamaSastraController;
use App\Http\Controllers\PengumumanController;

// AUTH ROUTE
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/admin/login', [AuthController::class, 'login'])->name('login');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('logout');

// UPLOAD IMAGE (TinyMCE, CKEditor, dsb.)
Route::post('/upload-image', [UploadController::class, 'store'])->name('upload.image');

// HALAMAN PUBLIK
Route::get('/', [PetaController::class, 'index'])->name('peta.index');
Route::get('/detail/bahasa/{id}', [PetaController::class, 'show'])->name('peta.bahasa.show');

Route::get('/sastra', [PetaSastraController::class, 'index'])->name('peta.sastra');
Route::get('/detail/sastra/{id}', [PetaSastraController::class, 'show'])->name('peta.sastra.show');

Route::get('/aksara', [PetaAksaraController::class, 'index'])->name('peta.aksara');
Route::get('/detail/aksara/{id}', [PetaAksaraController::class, 'show'])->name('peta.aksara.show');

Route::get('/tentang-kami', [TentangKamiController::class, 'index'])->name('tentang.kami');

Route::get('/kontak', function () {
    return view('pages.kontak');
});
Route::post('/kontak', [KontakController::class, 'store'])->name('kontak.store');

// ADMIN AREA (Perlu Login)
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');

    // Role admin & pegawai (umum)
    Route::resource('/admin/wilayah', WilayahController::class);
    Route::resource('/admin/nama-bahasa', NamaBahasaController::class);
    Route::resource('/admin/nama-sastra', NamaSastraController::class);
    Route::resource('/admin/nama-aksara', NamaAksaraController::class);
    Route::resource('/admin/pengumuman', PengumumanController::class);
    Route::resource('/admin/peta/bahasa', BahasaController::class);
    Route::resource('/admin/peta/aksara', AksaraController::class);
    Route::resource('/admin/peta/sastra', SastraController::class);

    // Pesan masuk dari kontak
    Route::get('/admin/pesan', [KontakController::class, 'index'])->name('kontak.index');
    Route::delete('/kontak/{id}', [KontakController::class, 'destroy'])->name('kontak.destroy');
});

// SUPERADMIN AREA
Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::resource('/admin/pengguna', AdminController::class);
});
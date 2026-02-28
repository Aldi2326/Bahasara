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

Route::get('/pengumuman', [PengumumanController::class, 'indexUser'])->name('pengumuman-user.index');
Route::get('/pengumuman/{id}', [PengumumanController::class, 'showPengumumanUser'])->name('pengumuman-user.show');

// ADMIN AREA (Perlu Login)
Route::middleware('auth')->group(function () {

    Route::get('/admin/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');

    // Role admin & pegawai (umum)
    Route::resource('/admin/wilayah', WilayahController::class);
    Route::delete('/wilayah/bulk-delete', [WilayahController::class, 'bulkDelete'])->name('wilayah.bulk_delete');
    Route::resource('/admin/nama-bahasa', NamaBahasaController::class);
    Route::delete('/nama-bahasa/bulk-delete', [NamaBahasaController::class, 'bulkDelete'])->name('nama-bahasa.bulk_delete');
    Route::resource('/admin/nama-sastra', NamaSastraController::class);
    Route::delete('/nama-sastra/bulk-delete', [NamaSastraController::class, 'bulkDelete'])->name('nama-sastra.bulk_delete');
    Route::resource('/admin/nama-aksara', NamaAksaraController::class);
    Route::delete('/nama-aksara/bulk-delete', [NamaAksaraController::class, 'bulkDelete'])->name('nama-aksara.bulk_delete');
    Route::resource('/admin/pengumuman', PengumumanController::class);
    Route::delete('/pengumuman/bulk-delete', [PengumumanController::class, 'bulkDelete'])->name('pengumuman.bulk_delete');
    Route::resource('/admin/peta/bahasa', BahasaController::class);
    Route::delete('/bahasa/bulk-delete', [BahasaController::class, 'bulkDelete'])->name('bahasa.bulk_delete');
    Route::resource('/admin/peta/aksara', AksaraController::class);
    Route::delete('/aksara/bulk-delete', [AksaraController::class, 'bulkDelete'])->name('aksara.bulk_delete');
    Route::resource('/admin/peta/sastra', SastraController::class);
    Route::delete('/sastra/bulk-delete', [SastraController::class, 'bulkDelete'])->name('sastra.bulk_delete');

    // Pesan masuk dari kontak
    Route::get('/admin/pesan', [KontakController::class, 'index'])->name('kontak.index');
    Route::delete('/kontak/bulk-delete', [KontakController::class, 'bulkDelete'])->name('kontak.bulk_delete');
    Route::delete('/kontak/{id}', [KontakController::class, 'destroy'])->name('kontak.destroy');

    // Balasan admin
    Route::get('/admin/pesan/{id}/reply', [KontakController::class, 'replyForm'])->name('kontak.reply.form');
    Route::post('/admin/pesan/{id}/reply', [KontakController::class, 'reply'])->name('kontak.reply');

});

// SUPERADMIN AREA
Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::resource('/admin/pengguna', AdminController::class);
    Route::delete('/pengguna/bulk-delete', [AdminController::class, 'bulkDelete'])->name('pengguna.bulk_delete');
});
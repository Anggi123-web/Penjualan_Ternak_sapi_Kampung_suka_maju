<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeternakController;
use App\Http\Controllers\MantriHewanController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\IklanController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\EdukasiController;

// Halaman utama — Katalog publik
Route::get('/', [FrontendController::class, 'beranda'])->name('beranda');
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/about-us', [FrontendController::class, 'about'])->name('about');
Route::get('/katalog/{id}', [KatalogController::class, 'show'])->name('katalog.show');
Route::get('/edukasi/{id}', [FrontendController::class, 'showEdukasi'])->name('edukasi.show');

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Peternak routes
Route::middleware(['auth', 'role:peternak'])->prefix('peternak')->group(function () {
    Route::get('/dashboard', [PeternakController::class, 'dashboard'])->name('peternak.dashboard');
    Route::get('/penjualan', [PeternakController::class, 'penjualan'])->name('peternak.penjualan');
    Route::get('/laporan', [PeternakController::class, 'laporan'])->name('peternak.laporan');
    Route::get('/akun', [PeternakController::class, 'akun'])->name('peternak.akun');
    Route::put('/akun', [PeternakController::class, 'updateAkun'])->name('peternak.akun.update');

    // CRUD Sapi
    Route::get('/sapi/create', [PeternakController::class, 'createSapi'])->name('peternak.sapi.create');
    Route::post('/sapi', [PeternakController::class, 'storeSapi'])->name('peternak.sapi.store');
    Route::get('/sapi/{id}', [PeternakController::class, 'showSapi'])->name('peternak.sapi.show');
    Route::get('/sapi/{id}/edit', [PeternakController::class, 'editSapi'])->name('peternak.sapi.edit');
    Route::put('/sapi/{id}', [PeternakController::class, 'updateSapi'])->name('peternak.sapi.update');
    Route::delete('/sapi/{id}', [PeternakController::class, 'deleteSapi'])->name('peternak.sapi.delete');
});

// Iklan Routes (Shared between Peternak and Pengurus Kampung)
Route::middleware(['auth', 'role:peternak,pengurus_kampung'])->prefix('kelola')->group(function () {
    Route::get('/iklan', [IklanController::class, 'index'])->name('iklan.index');
    Route::get('/iklan/create', [IklanController::class, 'create'])->name('iklan.create');
    Route::post('/iklan', [IklanController::class, 'store'])->name('iklan.store');
    Route::put('/iklan/{iklan}/approve', [IklanController::class, 'approve'])->name('iklan.approve');
    Route::put('/iklan/{iklan}/toggle', [IklanController::class, 'toggle'])->name('iklan.toggle');
    Route::delete('/iklan/{iklan}', [IklanController::class, 'destroy'])->name('iklan.destroy');
});

use App\Http\Controllers\KeranjangController;

// Pembeli routes
Route::middleware(['auth', 'role:pembeli'])->prefix('pembeli')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'pembeli'])->name('pembeli.dashboard');

    // Keranjang routes
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('pembeli.keranjang.index');
    Route::post('/keranjang', [KeranjangController::class, 'store'])->name('pembeli.keranjang.store');
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'destroy'])->name('pembeli.keranjang.destroy');
});

// Mantri Hewan routes
Route::middleware(['auth', 'role:mantri_hewan'])->prefix('mantri-hewan')->group(function () {
    Route::get('/dashboard', [MantriHewanController::class, 'dashboard'])->name('mantri_hewan.dashboard');
    Route::get('/pemeriksaan', [MantriHewanController::class, 'pemeriksaan'])->name('mantri_hewan.pemeriksaan');
    Route::get('/pemeriksaan/{id}', [MantriHewanController::class, 'showPemeriksaan'])->name('mantri_hewan.pemeriksaan.show');
    Route::put('/pemeriksaan/{id}/verifikasi', [MantriHewanController::class, 'verifikasi'])->name('mantri_hewan.verifikasi');
    Route::get('/riwayat', [MantriHewanController::class, 'riwayat'])->name('mantri_hewan.riwayat');
});

// Pengurus Kampung routes
Route::middleware(['auth', 'role:pengurus_kampung'])->prefix('pengurus-kampung')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'pengurusKampung'])->name('pengurus_kampung.dashboard');
    
    // Edukasi routes
    Route::get('/edukasi', [EdukasiController::class, 'index'])->name('pengurus_kampung.edukasi.index');
    Route::get('/edukasi/create', [EdukasiController::class, 'create'])->name('pengurus_kampung.edukasi.create');
    Route::post('/edukasi', [EdukasiController::class, 'store'])->name('pengurus_kampung.edukasi.store');
    Route::delete('/edukasi/{id}', [EdukasiController::class, 'destroy'])->name('pengurus_kampung.edukasi.destroy');
});

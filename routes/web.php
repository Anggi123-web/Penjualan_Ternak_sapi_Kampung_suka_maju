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
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PengurusKampung\KatalogController as PengurusKatalogController;
use App\Http\Controllers\PengurusKampung\MonitoringController as PengurusMonitoringController;
use App\Http\Controllers\PengurusKampung\PeternakController as PengurusPeternakController;
use App\Http\Controllers\PengurusKampung\LaporanController as PengurusLaporanController;

// Halaman utama — Katalog publik
Route::get('/', [FrontendController::class, 'beranda'])->name('beranda');
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/about-us', [FrontendController::class, 'about'])->name('about');
Route::get('/katalog/{id}', [KatalogController::class, 'show'])->name('katalog.show');
Route::get('/edukasi/{id}', [FrontendController::class, 'showEdukasi'])->name('edukasi.show');

// Fitur Chat Box Interaktif Pembeli & Penjual
Route::middleware('auth')->prefix('chat')->group(function () {
    Route::get('/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/unread-count', [ChatController::class, 'getUnreadCount'])->name('chat.unread_count');
    Route::get('/conversations', [ChatController::class, 'getConversations'])->name('chat.conversations');
});

// Alur Pembayaran
Route::get('/pembayaran/{sapi_id}', [PembayaranController::class, 'show'])->name('pembayaran.show');
Route::post('/pembayaran/{sapi_id}', [PembayaranController::class, 'store'])->name('pembayaran.store');
Route::get('/pembayaran/{transaksi_id}/upload', [PembayaranController::class, 'showUpload'])->name('pembayaran.upload');
Route::post('/pembayaran/{transaksi_id}/upload', [PembayaranController::class, 'processUpload'])->name('pembayaran.upload.process');
Route::get('/pembayaran/{transaksi_id}/sukses', [PembayaranController::class, 'sukses'])->name('pembayaran.sukses');
Route::get('/pembayaran/{transaksi_id}/pelunasan', [PembayaranController::class, 'showPelunasan'])->name('pembayaran.pelunasan');
Route::post('/pembayaran/{transaksi_id}/pelunasan', [PembayaranController::class, 'processPelunasan'])->name('pembayaran.pelunasan.process');

// Alur Monitoring Pemesanan Sapi
Route::get('/pemesanan', [PesananController::class, 'index'])->name('pesanan.index');
Route::post('/pemesanan/{id}/selesai', [PesananController::class, 'konfirmasiSelesai'])->name('pesanan.selesai')->middleware('auth');
Route::post('/pemesanan/{id}/ulasan', [PesananController::class, 'simpanUlasan'])->name('pesanan.ulasan')->middleware('auth');
Route::get('/pemesanan/{id}/surat-pdf', [PesananController::class, 'downloadSuratPdf'])->name('pesanan.surat_pdf')->middleware('auth');

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

    // Kelola Pesanan Masuk
    Route::get('/pesanan', [PeternakController::class, 'pesanan'])->name('peternak.pesanan');
    Route::put('/pesanan/{id}/status', [PeternakController::class, 'updateStatusPesanan'])->name('peternak.pesanan.update_status');
    Route::put('/pesanan/{id}/konfirmasi-pelunasan', [PeternakController::class, 'konfirmasiPelunasan'])->name('peternak.pesanan.konfirmasi_pelunasan');

    // Kelola Ulasan Pembeli
    Route::get('/ulasan', [PeternakController::class, 'ulasan'])->name('peternak.ulasan');
    Route::post('/ulasan/{id}/balas', [PeternakController::class, 'balasUlasan'])->name('peternak.ulasan.balas');

    // Sampah Sapi Peternak
    Route::get('/sampah', [PeternakController::class, 'sampah'])->name('peternak.sapi.sampah');
    Route::post('/sapi/{id}/restore', [PeternakController::class, 'restoreSapi'])->name('peternak.sapi.restore');
    Route::delete('/sapi/{id}/force-delete', [PeternakController::class, 'forceDeleteSapi'])->name('peternak.sapi.force_delete');
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

    // Katalog Penjualan & Sampah routes
    Route::get('/katalog', [PengurusKatalogController::class, 'index'])->name('pengurus_kampung.katalog.index');
    Route::put('/katalog/{id}/toggle', [PengurusKatalogController::class, 'toggleStatus'])->name('pengurus_kampung.katalog.toggle');
    Route::delete('/katalog/{id}/hapus', [PengurusKatalogController::class, 'softDelete'])->name('pengurus_kampung.katalog.soft_delete');
    Route::get('/katalog/sampah', [PengurusKatalogController::class, 'sampah'])->name('pengurus_kampung.katalog.sampah');
    Route::post('/katalog/{id}/pulihkan', [PengurusKatalogController::class, 'restore'])->name('pengurus_kampung.katalog.restore');
    Route::delete('/katalog/{id}/permanen', [PengurusKatalogController::class, 'forceDelete'])->name('pengurus_kampung.katalog.force_delete');

    // Surat Keterangan & Monitoring Pemesanan (Aparat Kampung)
    Route::get('/monitoring', [PengurusMonitoringController::class, 'index'])->name('pengurus_kampung.monitoring.index');
    Route::post('/monitoring/{id}/surat', [PengurusMonitoringController::class, 'uploadSurat'])->name('pengurus_kampung.monitoring.upload_surat');
    Route::get('/monitoring/{id}/surat-pdf', [PesananController::class, 'downloadSuratPdf'])->name('pengurus_kampung.monitoring.surat_pdf');
    Route::put('/monitoring/{id}/update', [PengurusMonitoringController::class, 'updateMonitoring'])->name('pengurus_kampung.monitoring.update');

    // Data Peternak
    Route::get('/peternak', [PengurusPeternakController::class, 'index'])->name('pengurus_kampung.peternak.index');
    Route::get('/peternak/{id}', [PengurusPeternakController::class, 'show'])->name('pengurus_kampung.peternak.show');

    // Laporan Penjualan Per Triwulan
    Route::get('/laporan-triwulan', [PengurusLaporanController::class, 'index'])->name('pengurus_kampung.laporan.index');
    Route::get('/laporan-triwulan/cetak', [PengurusLaporanController::class, 'cetak'])->name('pengurus_kampung.laporan.cetak');
    Route::get('/laporan-triwulan/pdf', [PengurusLaporanController::class, 'downloadPdf'])->name('pengurus_kampung.laporan.pdf');
});


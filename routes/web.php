<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\Mahasiswacontroller;
use App\Http\Controllers\UkuranController;




Route::get('/', fn() => redirect('/admin/dashboard'));

// Dashboard
Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->name('admin.dashboard');

// Alat — 6 route
Route::get('/admin/alat',            [AlatController::class, 'index'])->name('admin.alat');
Route::get('/admin/alat/create',     [AlatController::class, 'create'])->name('admin.alat.create');
Route::post('/admin/alat',           [AlatController::class, 'store'])->name('admin.alat.store');
Route::get('/admin/alat/{id}/edit',  [AlatController::class, 'edit'])->name('admin.alat.edit');
Route::put('/admin/alat/{id}',       [AlatController::class, 'update'])->name('admin.alat.update');
Route::delete('/admin/alat/{id}',    [AlatController::class, 'destroy'])->name('admin.alat.destroy');

Route::get('/admin/bahan',            [BahanController::class, 'index'])->name('admin.bahan');
Route::get('/admin/bahan/create',     [BahanController::class, 'create'])->name('admin.bahan.create');
Route::post('/admin/bahan',           [BahanController::class, 'store'])->name('admin.bahan.store');
Route::get('/admin/bahan/{id}/edit',  [BahanController::class, 'edit'])->name('admin.bahan.edit');
Route::put('/admin/bahan/{id}',       [BahanController::class, 'update'])->name('admin.bahan.update');
Route::delete('/admin/bahan/{id}',    [BahanController::class, 'destroy'])->name('admin.bahan.destroy');

Route::get('/admin/kategori',            [KategoriController::class, 'index'])->name('admin.kategori');
Route::get('/admin/kategori/create',     [KategoriController::class, 'create'])->name('admin.kategori.create');
Route::post('/admin/kategori',           [KategoriController::class, 'store'])->name('admin.kategori.store');
Route::get('/admin/kategori/{id}/edit',  [KategoriController::class, 'edit'])->name('admin.kategori.edit');
Route::put('/admin/kategori/{id}',       [KategoriController::class, 'update'])->name('admin.kategori.update');
Route::delete('/admin/kategori/{id}',    [KategoriController::class, 'destroy'])->name('admin.kategori.destroy');

// Satuan
Route::get('/admin/satuan',            [SatuanController::class, 'index'])->name('admin.satuan');
Route::get('/admin/satuan/create',     [SatuanController::class, 'create'])->name('admin.satuan.create');
Route::post('/admin/satuan',           [SatuanController::class, 'store'])->name('admin.satuan.store');
Route::get('/admin/satuan/{id}/edit',  [SatuanController::class, 'edit'])->name('admin.satuan.edit');
Route::put('/admin/satuan/{id}',       [SatuanController::class, 'update'])->name('admin.satuan.update');
Route::delete('/admin/satuan/{id}',    [SatuanController::class, 'destroy'])->name('admin.satuan.destroy');

// Ukuran
Route::get('/admin/ukuran',            [UkuranController::class, 'index'])->name('admin.ukuran');
Route::get('/admin/ukuran/create',     [UkuranController::class, 'create'])->name('admin.ukuran.create');
Route::post('/admin/ukuran',           [UkuranController::class, 'store'])->name('admin.ukuran.store');
Route::get('/admin/ukuran/{id}/edit',  [UkuranController::class, 'edit'])->name('admin.ukuran.edit');
Route::put('/admin/ukuran/{id}',       [UkuranController::class, 'update'])->name('admin.ukuran.update');
Route::delete('/admin/ukuran/{id}',    [UkuranController::class, 'destroy'])->name('admin.ukuran.destroy');

// Mahasiswa
Route::get('/admin/mahasiswa',            [MahasiswaController::class, 'index'])->name('admin.mahasiswa');
Route::get('/admin/mahasiswa/create',     [MahasiswaController::class, 'create'])->name('admin.mahasiswa.create');
Route::post('/admin/mahasiswa',           [MahasiswaController::class, 'store'])->name('admin.mahasiswa.store');
Route::get('/admin/mahasiswa/{id}/edit',  [MahasiswaController::class, 'edit'])->name('admin.mahasiswa.edit');
Route::put('/admin/mahasiswa/{id}',       [MahasiswaController::class, 'update'])->name('admin.mahasiswa.update');
Route::delete('/admin/mahasiswa/{id}',    [MahasiswaController::class, 'destroy'])->name('admin.mahasiswa.destroy');

// Halaman utama
Route::get('/admin/pengajuan', [PengajuanController::class, 'index'])
    ->name('admin.pengajuan');

// Peminjaman Alat
Route::get('/admin/pengajuan/alat/create',           [PengajuanController::class, 'createAlat'])->name('admin.pengajuan.alat.create');
Route::post('/admin/pengajuan/alat',                 [PengajuanController::class, 'storeAlat'])->name('admin.pengajuan.alat.store');
Route::post('/admin/pengajuan/alat/{id}/serahkan',   [PengajuanController::class, 'serahkanAlat'])->name('admin.pengajuan.alat.serahkan');
Route::post('/admin/pengajuan/alat/{id}/tolak',      [PengajuanController::class, 'tolakAlat'])->name('admin.pengajuan.alat.tolak');
Route::post('/admin/pengajuan/alat/{id}/kembali',    [PengajuanController::class, 'terimaKembali'])->name('admin.pengajuan.alat.kembali');

// Pemakaian Bahan
Route::get('/admin/pengajuan/bahan/create',          [PengajuanController::class, 'createBahan'])->name('admin.pengajuan.bahan.create');
Route::post('/admin/pengajuan/bahan',                [PengajuanController::class, 'storeBahan'])->name('admin.pengajuan.bahan.store');
Route::post('/admin/pengajuan/bahan/{id}/serahkan',  [PengajuanController::class, 'serahkanBahan'])->name('admin.pengajuan.bahan.serahkan');
Route::post('/admin/pengajuan/bahan/{id}/tolak',     [PengajuanController::class, 'tolakBahan'])->name('admin.pengajuan.bahan.tolak');
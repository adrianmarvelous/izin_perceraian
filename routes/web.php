<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Users list — semua user yang login bisa lihat
    Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('users');

    // Pegawai CRUD
    Route::resource('pegawai', App\Http\Controllers\PegawaiController::class);
    Route::get('/get-unit-kerja/{opdId}', [App\Http\Controllers\PegawaiController::class, 'getUnitKerja'])
        ->name('get-unit-kerja');

    // Master OPD CRUD (hanya akses via role admin)
    Route::middleware('can:admin')->group(function () {
        Route::resource('master-opd', App\Http\Controllers\MasterOpdController::class);
        Route::resource('master-unit-kerja', App\Http\Controllers\MasterUnitKerjaController::class);

        // Statistik Izin Perceraian
        Route::get('/statistik-perceraian', [App\Http\Controllers\PerceraianController::class, 'statistik'])->name('statistik');
        Route::get('/statistik-perceraian/pdf', [App\Http\Controllers\PerceraianController::class, 'statistikPdf'])->name('statistik.pdf');
    });

    // Izin Perceraian
    Route::prefix('perceraian')->name('perceraian.')->group(function () {
        Route::get('/', [App\Http\Controllers\PerceraianController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\PerceraianController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\PerceraianController::class, 'store'])->name('store');
        Route::get('/{perceraian}/edit', [App\Http\Controllers\PerceraianController::class, 'edit'])->name('edit');
        Route::put('/{perceraian}', [App\Http\Controllers\PerceraianController::class, 'update'])->name('update');
        Route::delete('/{perceraian}', [App\Http\Controllers\PerceraianController::class, 'destroy'])->name('destroy');
        Route::get('/{perceraian}/dokumen', [App\Http\Controllers\PerceraianController::class, 'dokumen'])->name('dokumen');
        Route::patch('/{perceraian}/dokumen/{dokumen}', [App\Http\Controllers\PerceraianController::class, 'updateDokumen'])->name('dokumen.update');
        Route::post('/{perceraian}/ajukan', [App\Http\Controllers\PerceraianController::class, 'ajukan'])->name('ajukan');
        Route::get('/{perceraian}/print', [App\Http\Controllers\PerceraianController::class, 'printPdf'])->name('print');
        Route::post('/{perceraian}/dokumen/{dokumen}/create-drive-folder', [App\Http\Controllers\PerceraianController::class, 'createDriveFolder'])->name('dokumen.create-drive-folder');
        Route::post('/{perceraian}/ms-tms/{value}', [App\Http\Controllers\PerceraianController::class, 'updateMsTms'])->name('ms-tms');
        Route::get('/{perceraian}/surat-panggilan', [App\Http\Controllers\PerceraianController::class, 'suratPanggilan'])->name('surat-panggilan');
        Route::get('/{perceraian}/laporan', [App\Http\Controllers\PerceraianController::class, 'laporan'])->name('laporan');
        Route::post('/{perceraian}/laporan', [App\Http\Controllers\PerceraianController::class, 'simpanLaporan'])->name('laporan.simpan');
        Route::get('/{perceraian}/laporan/pdf', [App\Http\Controllers\PerceraianController::class, 'laporanPdf'])->name('laporan.pdf');
        Route::get('/{perceraian}/rekomendasi', [App\Http\Controllers\PerceraianController::class, 'rekomendasi'])->name('rekomendasi');
        Route::get('/{perceraian}/berita-acara/{pihak}', [App\Http\Controllers\PerceraianController::class, 'beritaAcara'])->name('berita-acara');
        Route::post('/{perceraian}/berita-acara/{pihak}', [App\Http\Controllers\PerceraianController::class, 'simpanBeritaAcara'])->name('berita-acara.store');
        Route::get('/{perceraian}/berita-acara/{pihak}/pdf', [App\Http\Controllers\PerceraianController::class, 'beritaAcaraPdf'])->name('berita-acara.pdf');
        Route::get('/{perceraian}/berita-acara/{pihak}/pdf', [App\Http\Controllers\PerceraianController::class, 'beritaAcaraPdf'])->name('berita-acara.pdf');
        Route::post('/{perceraian}/teruskan-walikota', [App\Http\Controllers\PerceraianController::class, 'teruskanWalikota'])->name('teruskan-walikota');
        Route::post('/{perceraian}/rekomendasi-opd', [App\Http\Controllers\PerceraianController::class, 'rekomendasiOpd'])->name('rekomendasi-opd');
        Route::get('/{perceraian}/rekomendasi-opd/form', [App\Http\Controllers\PerceraianController::class, 'rekomendasiOpdForm'])->name('rekomendasi-opd.form');
        Route::post('/{perceraian}/rekomendasi-opd/simpan', [App\Http\Controllers\PerceraianController::class, 'simpanRekomendasiOpd'])->name('rekomendasi-opd.simpan');
        Route::get('/{perceraian}/rekomendasi-opd/pdf', [App\Http\Controllers\PerceraianController::class, 'rekomendasiOpdPdf'])->name('rekomendasi-opd.pdf');
        Route::get('/{perceraian}/sk', [App\Http\Controllers\PerceraianController::class, 'skWalikota'])->name('sk');
    });
});

Route::middleware(['auth', 'can:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::patch('/users/{user}/role', [App\Http\Controllers\AdminController::class, 'updateRole'])->name('users.role');
    Route::patch('/users/{user}/reset-password', [App\Http\Controllers\AdminController::class, 'resetPassword'])->name('users.reset-password');
    Route::delete('/users/{user}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('users.destroy');
});

require __DIR__.'/auth.php';

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
    });
});

Route::middleware(['auth', 'can:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::patch('/users/{user}/role', [App\Http\Controllers\AdminController::class, 'updateRole'])->name('users.role');
    Route::patch('/users/{user}/reset-password', [App\Http\Controllers\AdminController::class, 'resetPassword'])->name('users.reset-password');
    Route::delete('/users/{user}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('users.destroy');
});

require __DIR__.'/auth.php';

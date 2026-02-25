<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\ZonaPublicController;
use App\Http\Controllers\BendaPublicController;
use App\Http\Controllers\GatekeeperController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminZonaController;
use App\Http\Controllers\Admin\AdminBendaController;
use App\Http\Controllers\Admin\AdminSesiController;
use App\Http\Controllers\Admin\AdminTiketController;
use App\Http\Controllers\Admin\QrGeneratorController;
use App\Http\Controllers\Admin\LaporanController;

/*
|--------------------------------------------------------------------------
| Halaman Publik
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/reservasi', [ReservasiController::class, 'create'])->name('reservasi.create');
Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');
Route::get('/tiket/{kode}', [ReservasiController::class, 'show'])->name('tiket.show');
Route::get('/tiket/qr/{kode}', [ReservasiController::class, 'showQr'])->name('tiket.qr')->middleware('signed');
Route::post('/tiket/{kode}/cancel', [ReservasiController::class, 'cancel'])->name('tiket.cancel');
Route::post('/api/slot-tersedia', [ReservasiController::class, 'cekSlot'])->name('api.slot');
Route::get('/zona/{id}', [ZonaPublicController::class, 'show'])->name('zona.show');
Route::get('/benda/{id}', [BendaPublicController::class, 'show'])->name('benda.show');

/*
|--------------------------------------------------------------------------
| Gatekeeper (Petugas Gerbang)
|--------------------------------------------------------------------------
*/
Route::prefix('gatekeeper')->group(function () {
    Route::get('/login', [GatekeeperController::class, 'loginForm'])->name('gatekeeper.login');
    Route::post('/login', [GatekeeperController::class, 'login'])->name('gatekeeper.login.submit');
    Route::middleware(\App\Http\Middleware\CheckGatekeeper::class)->group(function () {
        Route::get('/scan', [GatekeeperController::class, 'scan'])->name('gatekeeper.scan');
        Route::post('/validate', [GatekeeperController::class, 'validate_ticket'])->name('gatekeeper.validate');
        Route::post('/logout', [GatekeeperController::class, 'logout'])->name('gatekeeper.logout');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Dashboard
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/login', [DashboardController::class, 'loginForm'])->name('admin.login');
    Route::post('/login', [DashboardController::class, 'login'])->name('admin.login.submit');

    Route::middleware(\App\Http\Middleware\CheckAdmin::class)->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::post('/logout', [DashboardController::class, 'logout'])->name('admin.logout');

        // CRUD Zona
        Route::get('/zona', [AdminZonaController::class, 'index'])->name('admin.zona.index');
        Route::get('/zona/create', [AdminZonaController::class, 'create'])->name('admin.zona.create');
        Route::post('/zona', [AdminZonaController::class, 'store'])->name('admin.zona.store');
        Route::get('/zona/{id}/edit', [AdminZonaController::class, 'edit'])->name('admin.zona.edit');
        Route::put('/zona/{id}', [AdminZonaController::class, 'update'])->name('admin.zona.update');
        Route::delete('/zona/{id}', [AdminZonaController::class, 'destroy'])->name('admin.zona.destroy');

        // CRUD Benda Sejarah
        Route::get('/benda', [AdminBendaController::class, 'index'])->name('admin.benda.index');
        Route::get('/benda/create', [AdminBendaController::class, 'create'])->name('admin.benda.create');
        Route::post('/benda', [AdminBendaController::class, 'store'])->name('admin.benda.store');
        Route::get('/benda/{id}/edit', [AdminBendaController::class, 'edit'])->name('admin.benda.edit');
        Route::put('/benda/{id}', [AdminBendaController::class, 'update'])->name('admin.benda.update');
        Route::delete('/benda/{id}', [AdminBendaController::class, 'destroy'])->name('admin.benda.destroy');

        // CRUD Sesi Kunjungan
        Route::get('/sesi', [AdminSesiController::class, 'index'])->name('admin.sesi.index');
        Route::get('/sesi/create', [AdminSesiController::class, 'create'])->name('admin.sesi.create');
        Route::post('/sesi', [AdminSesiController::class, 'store'])->name('admin.sesi.store');
        Route::delete('/sesi/{id}', [AdminSesiController::class, 'destroy'])->name('admin.sesi.destroy');

        // Tiket
        Route::get('/tiket', [AdminTiketController::class, 'index'])->name('admin.tiket.index');
        Route::post('/tiket/{id}/cancel', [AdminTiketController::class, 'cancel'])->name('admin.tiket.cancel');

        // QR Generator
        Route::get('/qr-generator', [QrGeneratorController::class, 'index'])->name('admin.qr.index');
        Route::post('/qr-generator/{zona}', [QrGeneratorController::class, 'generate'])->name('admin.qr.generate');

        // Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');
        Route::get('/laporan/data', [LaporanController::class, 'getData'])->name('admin.laporan.data');
    });
});

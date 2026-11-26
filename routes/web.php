<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\EquipmentController;

/*
|--------------------------------------------------------------------------
| W-Track Routes
|--------------------------------------------------------------------------
*/

// Redirect root -> login
Route::get('/', function () {
    return redirect()->route('login');
});

// ── AUTH (Guest only) ──────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Forgot password placeholder
Route::get('/password/reset', function () {
    return redirect()->route('login')->with('error', 'Fitur reset password belum tersedia.');
})->name('password.request');

// ── TRANSAKSI & RFID API (WTR-03 & WTR-04) ──────────────
Route::post('/scan-out', [TransactionController::class, 'scanOut'])->name('scan.out');
Route::post('/scan-in', [TransactionController::class, 'scanIn'])->name('scan.in');

// ── AUTHENTICATED ROUTES ────────────────────────────────
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Menu Utama Design Handoff
    Route::get('/equipment', [EquipmentController::class, 'index'])->name('equipment.index');
    Route::get('/monitoring-iot', fn() => view('coming-soon', ['page' => 'Monitoring IoT']))->name('monitoring-iot.index');
    Route::get('/transaksi', fn() => view('coming-soon', ['page' => 'Transaksi']))->name('transaksi.index');
    Route::get('/riwayat', fn() => view('coming-soon', ['page' => 'Riwayat']))->name('riwayat.index');

    // Rute lama (dipertahankan sementara agar tidak error jika masih dipanggil)
    Route::get('/pemeliharaan', fn() => view('coming-soon', ['page' => 'Pemeliharaan']))->name('pemeliharaan.index');
    Route::get('/laporan',     fn() => view('coming-soon', ['page' => 'Laporan']))->name('laporan.index');
    Route::get('/pengaturan',  fn() => view('coming-soon', ['page' => 'Pengaturan']))->name('pengaturan.index');
    Route::get('/notifikasi',  fn() => view('coming-soon', ['page' => 'Notifikasi']))->name('notifikasi.index');
});
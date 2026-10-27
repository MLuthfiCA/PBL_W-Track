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

// Redirect root → login
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

// ── TRANSAKSI & RFID API (WTR-03) ───────────────────────
// Endpoint ini dibuka agar dapat dipanggil oleh simulasi/sensor RFID tanpa terhalang auth session
Route::post('/scan-out', [TransactionController::class, 'scanOut'])->name('scan.out');

// ── AUTHENTICATED ROUTES ────────────────────────────────
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Placeholder routes (akan diisi di sprint berikutnya)
    Route::get('/equipment', [EquipmentController::class, 'index'])
        ->name('equipment.index');    
    Route::get('/pemeliharaan', fn() => view('coming-soon', ['page' => 'Pemeliharaan']))->name('pemeliharaan.index');
    Route::get('/laporan',     fn() => view('coming-soon', ['page' => 'Laporan']))->name('laporan.index');
    Route::get('/pengaturan',  fn() => view('coming-soon', ['page' => 'Pengaturan']))->name('pengaturan.index');
    Route::get('/notifikasi',  fn() => view('coming-soon', ['page' => 'Notifikasi']))->name('notifikasi.index');
});
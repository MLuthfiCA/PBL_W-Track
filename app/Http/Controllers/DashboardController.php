<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard.
     */
    public function index()
    {
        // ── Statistik dari database ────────────────────────
        $total     = Equipment::count();
        $digunakan = Equipment::where('status', 'borrowed')->count();
        $tersedia  = Equipment::where('status', 'available')->count();
        $perbaikan = 0; // Status 'perbaikan' belum ada di tabel equipments

        $stats = [
            'total'     => $total,
            'digunakan' => $digunakan,
            'perbaikan' => $perbaikan,
            'tersedia'  => $tersedia,
        ];

        // ── Equipment terbaru (5 terakhir ditambahkan) ─────
        $equipmentTerbaru = Equipment::latest()
            ->take(5)
            ->get()
            ->map(function ($eq) {
                $statusLabel = match ($eq->status) {
                    'borrowed'  => 'Digunakan',
                    'available' => 'Tersedia',
                    default     => 'Tersedia',
                };

                return [
                    'nama'   => $eq->name,
                    'kode'   => $eq->rfid_uid,
                    'lokasi' => $eq->category,
                    'status' => $statusLabel,
                ];
            });

        // ── Aktivitas terbaru (10 transaksi terakhir) ──────
        $aktivitas = Transaction::with('equipment')
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($trx) {
                $equipmentName = $trx->equipment->name ?? 'Equipment tidak diketahui';
                $action = $trx->type === 'out'
                    ? "{$equipmentName} dipinjam (keluar)"
                    : "{$equipmentName} dikembalikan (masuk)";

                return [
                    'text' => $action,
                    'time' => $trx->created_at->diffForHumans(),
                ];
            });

        return view('dashboard.index', compact('stats', 'equipmentTerbaru', 'aktivitas'));
    }
}

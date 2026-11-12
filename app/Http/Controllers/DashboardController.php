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
        $digunakan = Equipment::where('status', 'borrowed')->count();    // Merah
        $tersedia  = Equipment::where('status', 'available')->count();   // Hijau
        $perbaikan = Equipment::where('status', 'maintenance')->count(); // Orange

        $stats = [
            'total'     => $total,
            'digunakan' => $digunakan,
            'perbaikan' => $perbaikan,
            'tersedia'  => $tersedia,
        ];

        // ── Perhitungan Donut Chart (Circumference 251.2) ──
        $circumference = 251.2;
        if ($total > 0) {
            $lenAvail    = round(($tersedia / $total) * $circumference, 2);
            $lenRepair   = round(($perbaikan / $total) * $circumference, 2);
            $lenBorrowed = round(($digunakan / $total) * $circumference, 2);

            $offsetAvail    = 0;
            $offsetRepair   = -$lenAvail;
            $offsetBorrowed = -($lenAvail + $lenRepair);
        } else {
            $lenAvail    = 0;
            $lenRepair   = 0;
            $lenBorrowed = 0;
            $offsetAvail    = 0;
            $offsetRepair   = 0;
            $offsetBorrowed = 0;
        }

        $chart = [
            'circumference'   => $circumference,
            'avail_len'       => $lenAvail,
            'avail_offset'    => $offsetAvail,
            'repair_len'      => $lenRepair,
            'repair_offset'   => $offsetRepair,
            'borrowed_len'    => $lenBorrowed,
            'borrowed_offset' => $offsetBorrowed,
            'avail_pct'       => $total > 0 ? round(($tersedia / $total) * 100) : 0,
        ];

        // ── Equipment terbaru (5 terakhir ditambahkan) ─────
        $equipmentTerbaru = Equipment::latest()
            ->take(5)
            ->get()
            ->map(function ($eq) {
                $statusLabel = match ($eq->status) {
                    'borrowed'    => 'Dipinjam',
                    'available'   => 'Tersedia',
                    'maintenance' => 'Perbaikan',
                    default       => 'Tersedia',
                };

                return [
                    'nama'   => $eq->name,
                    'kode'   => $eq->rfid_uid,
                    'lokasi' => $eq->category,
                    'status' => $statusLabel,
                ];
            });

        // ── 3 Most Recent Aktivitas di Web ──────────────────
        $activityList = collect();

        // 1. Aktivitas Tambah Tools (Admin tambah tools)
        $addedEquipments = Equipment::latest('created_at')->take(5)->get();
        foreach ($addedEquipments as $eq) {
            $activityList->push([
                'title'     => 'Equipment Ditambahkan',
                'text'      => "Admin menambahkan {$eq->name} ke kategori {$eq->category}.",
                'time'      => $eq->created_at->diffForHumans(),
                'timestamp' => $eq->created_at,
                'color'     => '#10B981', // Hijau
                'icon'      => 'ri-add-circle-fill',
            ]);
        }

        // 2. Aktivitas Tools yang Sedang Diperbaiki
        $maintenanceEquipments = Equipment::where('status', 'maintenance')->latest('updated_at')->take(5)->get();
        foreach ($maintenanceEquipments as $eq) {
            $activityList->push([
                'title'     => 'Dalam Perbaikan',
                'text'      => "{$eq->name} dimasukkan ke status perbaikan workshop.",
                'time'      => $eq->updated_at->diffForHumans(),
                'timestamp' => $eq->updated_at,
                'color'     => '#F59E0B', // Orange
                'icon'      => 'ri-tools-fill',
            ]);
        }

        // 3. Aktivitas Tools yang Dipinjam
        $borrowedEquipments = Equipment::where('status', 'borrowed')->latest('updated_at')->take(5)->get();
        foreach ($borrowedEquipments as $eq) {
            $activityList->push([
                'title'     => 'Equipment Dipinjam',
                'text'      => "{$eq->name} sedang dipinjam dan dibawa keluar.",
                'time'      => $eq->updated_at->diffForHumans(),
                'timestamp' => $eq->updated_at,
                'color'     => '#EF4444', // Merah
                'icon'      => 'ri-arrow-right-up-line',
            ]);
        }

        // 4. Transaksi RFID (jika ada)
        $transactions = Transaction::with('equipment')->latest()->take(5)->get();
        foreach ($transactions as $trx) {
            $name = $trx->equipment->name ?? 'Equipment';
            $isOut = $trx->type === 'out';
            $activityList->push([
                'title'     => $isOut ? 'Equipment Dipinjam (RFID)' : 'Equipment Dikembalikan (RFID)',
                'text'      => $isOut ? "{$name} dipinjam via scan RFID." : "{$name} dikembalikan ke workshop via scan RFID.",
                'time'      => $trx->created_at->diffForHumans(),
                'timestamp' => $trx->created_at,
                'color'     => $isOut ? '#EF4444' : '#10B981',
                'icon'      => $isOut ? 'ri-rfid-line' : 'ri-checkbox-circle-fill',
            ]);
        }

        // Ambil 3 aktivitas paling baru
        $aktivitas = $activityList->sortByDesc('timestamp')->unique(function ($item) {
            return $item['title'] . $item['text'];
        })->take(3)->values();

        return view('dashboard.index', compact('stats', 'equipmentTerbaru', 'aktivitas', 'chart'));
    }
}

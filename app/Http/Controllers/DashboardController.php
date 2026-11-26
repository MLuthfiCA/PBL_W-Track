<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Transaction;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard W-Track berdasarkan data aktual database.
     */
    public function index()
    {
        // 1. Hitung statistik aktual dari tabel equipments
        $totalEquipment = Equipment::count();
        $diWorkshop     = Equipment::where('status', 'available')->count();
        $diLuarWorkshop = Equipment::where('status', 'borrowed')->count();

        $stats = [
            'total'       => $totalEquipment,
            'di_workshop' => $diWorkshop,
            'di_luar'     => $diLuarWorkshop,
        ];

        // 2. Ambil 5 aktivitas transaksi terbaru beserta relasi equipment
        $recentTransactions = Transaction::with('equipment')
            ->latest()
            ->take(5)
            ->get();

        $aktivitasTerbaru = $recentTransactions->map(function ($trx) {
            $equipment = $trx->equipment;
            $kode = $equipment && !empty($equipment->code)
                ? $equipment->code
                : ($equipment ? 'EQ-' . str_pad($equipment->id, 3, '0', STR_PAD_LEFT) : '-');

            return [
                'id'        => $trx->id,
                'nama'      => $equipment->name ?? 'Equipment Tidak Dikenal',
                'kode'      => $kode,
                'rfid_uid'  => $equipment->rfid_uid ?? '-',
                'type'      => $trx->type, // 'in' atau 'out'
                'waktu'     => $trx->created_at ? $trx->created_at->timezone('Asia/Jakarta')->format('H:i') . ' WIB' : '-',
                'tanggal'   => $trx->created_at ? $trx->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB' : '-',
                'pengguna'  => $trx->officer_name ?? 'Sistem RFID',
            ];
        });

        // 3. Status Perangkat IoT (Jujur sesuai kondisi aktual hardware belum terhubung)
        $iotDevices = [
            [
                'name'      => 'RFID Reader 01',
                'location'  => 'Pintu Workshop',
                'status'    => 'offline',
                'last_seen' => $recentTransactions->first()
                    ? $recentTransactions->first()->created_at->timezone('Asia/Jakarta')->format('H:i') . ' WIB'
                    : 'Belum terhubung',
                'message'   => 'Perangkat tidak terhubung. Pemeriksaan koneksi diperlukan.',
            ],
            [
                'name'      => 'RFID Reader 02',
                'location'  => 'Pintu Gudang',
                'status'    => 'offline',
                'last_seen' => 'Belum terhubung',
                'message'   => 'Perangkat tidak terhubung. Pemeriksaan koneksi diperlukan.',
            ],
        ];

        // 4. Notifikasi Terbaru (gabungan transaksi aktual + status koneksi IoT)
        $notifikasi = collect();

        foreach ($aktivitasTerbaru->take(2) as $act) {
            $aksiText = $act['type'] === 'in'
                ? 'berhasil terdeteksi masuk.'
                : 'terdeteksi keluar.';

            $notifikasi->push([
                'type'    => $act['type'] === 'in' ? 'success' : 'warning',
                'message' => "{$act['nama']} ({$act['kode']}) {$aksiText}",
                'time'    => $act['waktu'],
            ]);
        }

        $notifikasi->push([
            'type'    => 'danger',
            'message' => 'RFID Reader 01 & 02 belum terhubung ke server.',
            'time'    => now()->timezone('Asia/Jakarta')->format('H:i') . ' WIB',
        ]);

        $lastUpdated = $recentTransactions->first()
            ? $recentTransactions->first()->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB'
            : now()->timezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB';

        return view('dashboard.index', compact(
            'stats',
            'aktivitasTerbaru',
            'iotDevices',
            'notifikasi',
            'lastUpdated'
        ));
    }
}
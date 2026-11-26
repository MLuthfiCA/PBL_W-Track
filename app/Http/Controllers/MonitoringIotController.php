<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class MonitoringIotController extends Controller
{
    /**
     * Tampilkan halaman Monitoring IoT berdasarkan kondisi aktual sistem & database.
     */
    public function index()
    {
        $latestTransactions = Transaction::with('equipment')
            ->latest()
            ->take(5)
            ->get();

        $lastTrxTime = $latestTransactions->first()
            ? $latestTransactions->first()->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB'
            : 'Belum ada data masuk';

        // Status jujur sesuai kondisi hardware fisik (belum terhubung ke server)
        $devices = [
            [
                'id'          => 'GATE-01',
                'name'        => 'RFID Reader 01',
                'location'    => 'Pintu Utama Workshop',
                'board'       => 'ESP32 DevKit V1 + RC522 (SPI)',
                'endpoint'    => 'POST /scan-out & POST /scan-in',
                'status'      => 'offline',
                'reader_state'=> 'Offline',
                'last_seen'   => $lastTrxTime,
                'message'     => 'Perangkat fisik belum terhubung ke jaringan. Pemeriksaan koneksi diperlukan.',
            ],
            [
                'id'          => 'GATE-02',
                'name'        => 'RFID Reader 02',
                'location'    => 'Pintu Gudang Peralatan',
                'board'       => 'ESP32 DevKit V1 + RC522 (SPI)',
                'endpoint'    => 'POST /scan-out & POST /scan-in',
                'status'      => 'offline',
                'reader_state'=> 'Offline',
                'last_seen'   => 'Belum terhubung',
                'message'     => 'Perangkat fisik belum terhubung ke jaringan. Pemeriksaan koneksi diperlukan.',
            ],
        ];

        return view('monitoring-iot.index', compact('devices', 'latestTransactions'));
    }

    /**
     * Tampilkan halaman Pusat Notifikasi W-Track.
     */
    public function notifications()
    {
        $transactions = Transaction::with('equipment')
            ->latest()
            ->take(10)
            ->get();

        $notifications = collect();

        // Notifikasi status koneksi perangkat IoT
        $notifications->push([
            'type'    => 'danger',
            'title'   => 'Gangguan Koneksi Perangkat RFID',
            'message' => 'RFID Reader 01 dan RFID Reader 02 berstatus Offline (belum terhubung dengan server W-Track).',
            'time'    => now()->timezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB',
        ]);

        // Gabungkan riwayat transaksi aktual sebagai log pemberitahuan
        foreach ($transactions as $trx) {
            $eq = $trx->equipment;
            $kode = $eq ? 'EQ-' . str_pad($eq->id, 3, '0', STR_PAD_LEFT) : '-';
            $nama = $eq->name ?? 'Equipment';

            if ($trx->type === 'in') {
                $notifications->push([
                    'type'    => 'success',
                    'title'   => 'Equipment Masuk Workshop',
                    'message' => "{$nama} ({$kode}) berhasil tercatat masuk kembali ke workshop.",
                    'time'    => $trx->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB',
                ]);
            } else {
                $notifications->push([
                    'type'    => 'warning',
                    'title'   => 'Equipment Keluar Workshop',
                    'message' => "{$nama} ({$kode}) tercatat dibawa keluar dari workshop.",
                    'time'    => $trx->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB',
                ]);
            }
        }

        return view('notifikasi.index', compact('notifications'));
    }
}


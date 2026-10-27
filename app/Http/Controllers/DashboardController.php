<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard.
     */
    public function index()
    {
        // Data statistik sementara.
        // Nantinya akan diambil dari database setelah
        // fitur equipment dan transaksi selesai dibuat.
        $stats = [
            'total'    => 248,
            'keluar'   => 176,
            'workshop' => 72,
        ];

        // Data equipment terbaru sementara.
        // Nantinya akan diambil dari tabel equipment.
        $equipmentTerbaru = [
            [
                'nama'   => 'Gerinda Tangan 4 Inch',
                'kode'   => 'TW-00124',
                'lokasi' => 'Meja Kerja 2',
                'status' => 'Keluar',
            ],
            [
                'nama'   => 'Solder Digital 60W',
                'kode'   => 'TW-00089',
                'lokasi' => 'Workshop',
                'status' => 'Di Workshop',
            ],
            [
                'nama'   => 'Multitester Digital',
                'kode'   => 'TW-00156',
                'lokasi' => 'Workshop',
                'status' => 'Di Workshop',
            ],
            [
                'nama'   => 'Bor Listrik 13mm',
                'kode'   => 'TW-00211',
                'lokasi' => 'Meja Kerja 4',
                'status' => 'Keluar',
            ],
        ];

        // Aktivitas terbaru sementara.
        // Nantinya akan berasal dari transaksi equipment.
        $aktivitas = [
            [
                'text' => 'Gerinda Tangan 4 Inch keluar dari workshop',
                'time' => '1 jam lalu',
            ],
            [
                'text' => 'Solder Digital 60W masuk kembali ke workshop',
                'time' => '2 jam lalu',
            ],
            [
                'text' => 'Multitester Digital masuk ke workshop',
                'time' => '3 jam lalu',
            ],
            [
                'text' => 'Bor Listrik 13mm keluar dari workshop',
                'time' => '5 jam lalu',
            ],
        ];

        return view(
            'dashboard.index',
            compact('stats', 'equipmentTerbaru', 'aktivitas')
        );
    }
}

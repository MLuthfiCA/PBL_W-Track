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
        // Data statistik (nantinya dari database)
        $stats = [
            'total'     => 248,
            'digunakan' => 176,
            'perbaikan' => 18,
            'tersedia'  => 54,
        ];

        // Data equipment terbaru (nantinya dari model Equipment)
        $equipmentTerbaru = [
            [
                'nama'   => 'Gerinda Tangan 4 Inch',
                'kode'   => 'TW-00124',
                'lokasi' => 'Meja Kerja 2',
                'status' => 'Digunakan',
            ],
            [
                'nama'   => 'Solder Digital 60W',
                'kode'   => 'TW-00089',
                'lokasi' => 'Meja Kerja 1',
                'status' => 'Perbaikan',
            ],
            [
                'nama'   => 'Multitester Digital',
                'kode'   => 'TW-00156',
                'lokasi' => 'Rak Alat 3',
                'status' => 'Tersedia',
            ],
            [
                'nama'   => 'Bor Listrik 13mm',
                'kode'   => 'TW-00211',
                'lokasi' => 'Meja Kerja 4',
                'status' => 'Digunakan',
            ],
        ];

        // Aktivitas terbaru (nantinya dari model Aktivitas)
        $aktivitas = [
            ['text' => 'Gerinda tangan dipindahkan ke Meja Kerja 2', 'time' => '1 jam lalu'],
            ['text' => 'Solder dipindahkan ke Meja Kerja 2',          'time' => '2 jam lalu'],
            ['text' => 'Multitester ditandai tersedia',                'time' => '3 jam lalu'],
            ['text' => 'Bor Listrik 13mm masuk perbaikan',             'time' => '5 jam lalu'],
        ];

        return view('dashboard.index', compact('stats', 'equipmentTerbaru', 'aktivitas'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Memproses pencatatan transaksi equipment keluar (WTR-03)
     */
    public function scanOut(Request $request)
    {
        // 1. Validasi input request
        $request->validate([
            'rfid_uid' => 'required|string',
        ]);

        // 2. Cari equipment berdasarkan RFID UID
        $equipment = Equipment::where('rfid_uid', $request->rfid_uid)->first();

        // AC Check 1: Jika RFID UID tidak ditemukan di master data
        if (!$equipment) {
            return response()->json([
                'success' => false,
                'message' => 'Tag RFID tidak terdaftar dalam sistem W-Track.'
            ], 404);
        }

        // AC Check 2: Jika equipment sudah berstatus dipinjam/keluar
        if ($equipment->status === 'borrowed') {
            return response()->json([
                'success' => false,
                'message' => 'Equipment ini sudah tercatat berada di luar workshop.'
            ], 400);
        }

        // 3. Catat transaksi keluar baru ke database
        $transaction = Transaction::create([
            'equipment_id' => $equipment->id,
            'type'         => 'out',
        ]);

        // 4. Otomatis perbarui status equipment menjadi borrowed
        $equipment->update([
            'status' => 'borrowed'
        ]);

        // 5. Kembalikan respons sukses
        return response()->json([
            'success' => true,
            'message' => 'Transaksi keluar berhasil dicatat.',
            'data'    => [
                'equipment_name' => $equipment->name,
                'rfid_uid'       => $equipment->rfid_uid,
                'status'         => $equipment->status,
                'time_out'       => $transaction->created_at->format('Y-m-d H:i:s'),
            ]
        ], 200);
    }

    /**
     * Memproses pencatatan transaksi equipment masuk / pengembalian (WTR-04)
     */
    public function scanIn(Request $request)
    {
        // 1. Validasi input request
        $request->validate([
            'rfid_uid' => 'required|string',
        ]);

        // 2. Cari equipment berdasarkan RFID UID
        $equipment = Equipment::where('rfid_uid', $request->rfid_uid)->first();

        // AC Check 1: Jika RFID UID tidak ditemukan
        if (!$equipment) {
            return response()->json([
                'success' => false,
                'message' => 'Tag RFID tidak terdaftar dalam sistem W-Track.'
            ], 404);
        }

        // AC Check 2: Jika equipment sudah berstatus available (belum dipinjam)
        if ($equipment->status === 'available') {
            return response()->json([
                'success' => false,
                'message' => 'Equipment ini sudah berada di dalam workshop (belum dipinjam/dibawa keluar).'
            ], 400);
        }

        // 3. Catat transaksi masuk (pengembalian) ke database
        $transaction = Transaction::create([
            'equipment_id' => $equipment->id,
            'type'         => 'in',
        ]);

        // 4. Otomatis kembalikan status equipment menjadi available
        $equipment->update([
            'status' => 'available'
        ]);

        // 5. Kembalikan respons sukses
        return response()->json([
            'success' => true,
            'message' => 'Transaksi masuk (pengembalian) berhasil dicatat.',
            'data'    => [
                'equipment_name' => $equipment->name,
                'rfid_uid'       => $equipment->rfid_uid,
                'status'         => $equipment->status,
                'time_in'        => $transaction->created_at->format('Y-m-d H:i:s'),
            ]
        ], 200);
    }
}
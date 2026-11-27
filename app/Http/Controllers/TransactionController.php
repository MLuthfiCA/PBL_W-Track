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
     * API endpoint terpadu untuk ESP32/IoT
     * POST /api/scan
     * Body JSON: { "uid": "XXXX", "type": "out"|"in" }
     */
    public function storeFromIoT(Request $request)
    {
        // 1. Validasi input JSON
        $validated = $request->validate([
            'uid'  => 'required|string',
            'type' => 'required|string|in:out,in',
        ]);

        // 2. Cari equipment berdasarkan RFID UID
        $equipment = Equipment::where('rfid_uid', $validated['uid'])->first();

        if (!$equipment) {
            return response()->json([
                'success' => false,
                'message' => 'RFID UID tidak ditemukan dalam sistem.',
            ], 404);
        }

        // 3. Logika berdasarkan tipe transaksi
        if ($validated['type'] === 'out') {
            // Cek apakah sudah dipinjam
            if ($equipment->status === 'borrowed') {
                return response()->json([
                    'success' => false,
                    'message' => 'Equipment "' . $equipment->name . '" sudah berstatus dipinjam.',
                ], 400);
            }

            // Cek apakah sedang dalam perbaikan
            if ($equipment->status === 'maintenance') {
                return response()->json([
                    'success' => false,
                    'message' => 'Equipment "' . $equipment->name . '" sedang dalam perbaikan, tidak bisa dipinjam.',
                ], 400);
            }

            // Catat transaksi keluar & update status
            $transaction = Transaction::create([
                'equipment_id' => $equipment->id,
                'type'         => 'out',
            ]);

            $equipment->update(['status' => 'borrowed']);

            return response()->json([
                'success' => true,
                'message' => 'Equipment berhasil dicatat KELUAR.',
                'data'    => [
                    'equipment_name' => $equipment->name,
                    'rfid_uid'       => $equipment->rfid_uid,
                    'status'         => 'borrowed',
                    'timestamp'      => $transaction->created_at->format('Y-m-d H:i:s'),
                ]
            ], 200);

        } else {
            // type === 'in'
            // Cek apakah sudah tersedia
            if ($equipment->status === 'available') {
                return response()->json([
                    'success' => false,
                    'message' => 'Equipment "' . $equipment->name . '" sudah berstatus tersedia.',
                ], 400);
            }

            // Catat transaksi masuk & update status
            $transaction = Transaction::create([
                'equipment_id' => $equipment->id,
                'type'         => 'in',
            ]);

            $equipment->update(['status' => 'available']);

            return response()->json([
                'success' => true,
                'message' => 'Equipment berhasil dicatat MASUK.',
                'data'    => [
                    'equipment_name' => $equipment->name,
                    'rfid_uid'       => $equipment->rfid_uid,
                    'status'         => 'available',
                    'timestamp'      => $transaction->created_at->format('Y-m-d H:i:s'),
                ]
            ], 200);
        }
    }
}
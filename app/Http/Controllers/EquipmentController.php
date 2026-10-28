<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    /**
     * Tampilkan daftar equipment.
     */
    public function index()
    {
        $equipments = Equipment::orderBy('created_at', 'desc')->get();
        return view('equipment.index', compact('equipments'));
    }

    /**
     * Simpan equipment baru beserta validasi UID RFID.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string|max:255',
            'rfid_uid'    => 'required|string|max:255|unique:equipments,rfid_uid',
        ], [
            'name.required'     => 'Nama equipment wajib diisi.',
            'category.required' => 'Kategori wajib diisi.',
            'rfid_uid.required' => 'UID Tag RFID wajib diisi.',
            'rfid_uid.unique'   => 'UID RFID ini sudah terdaftar pada alat lain!',
        ]);

        Equipment::create([
            'name'     => $validated['name'],
            'category' => $validated['category'],
            'rfid_uid' => $validated['rfid_uid'],
            'status'   => 'available', // Status awal default
        ]);

        return redirect()->route('equipment.index')->with('success', 'Equipment berhasil ditambahkan!');
    }

    /**
     * Update data equipment.
     */
    public function update(Request $request, $id)
    {
        $equipment = Equipment::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string|max:255',
            'rfid_uid'    => 'required|string|max:255|unique:equipments,rfid_uid,' . $id,
            'status'      => 'required|in:available,borrowed,maintenance',
        ]);

        $equipment->update($validated);

        return redirect()->route('equipment.index')->with('success', 'Data equipment berhasil diperbarui!');
    }

    /**
     * Hapus equipment dari database.
     */
    public function destroy($id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();

        return redirect()->route('equipment.index')->with('success', 'Equipment berhasil dihapus!');
    }
}
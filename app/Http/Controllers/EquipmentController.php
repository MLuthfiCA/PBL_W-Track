<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    /**
     * Tampilkan daftar equipment dengan dukungan pencarian dan filter status.
     */
    public function index(Request $request)
    {
        $query = Equipment::query();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('rfid_uid', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && in_array($request->status, ['available', 'borrowed'])) {
            $query->where('status', $request->status);
        }

        $equipments = $query->orderBy('created_at', 'desc')->get();

        return view('equipment.index', compact('equipments'));
    }

    /**
     * Simpan data equipment baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:150',
            'rfid_uid' => 'required|string|max:50|unique:equipments,rfid_uid',
            'category' => 'required|string|max:100',
        ], [
            'name.required'     => 'Nama equipment wajib diisi.',
            'rfid_uid.required' => 'UID Tag RFID wajib diisi.',
            'rfid_uid.unique'   => 'UID Tag RFID sudah terdaftar pada equipment lain.',
            'category.required' => 'Kategori equipment wajib dipilih.',
        ]);

        Equipment::create([
            'name'     => $validated['name'],
            'rfid_uid' => strtoupper(trim($validated['rfid_uid'])),
            'category' => $validated['category'],
            'status'   => 'available',
        ]);

        return redirect()
            ->route('equipment.index')
            ->with('success', 'Data equipment baru berhasil ditambahkan.');
    }

    /**
     * Perbarui data equipment yang sudah ada.
     */
    public function update(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:150',
            'rfid_uid' => 'required|string|max:50|unique:equipments,rfid_uid,' . $equipment->id,
            'category' => 'required|string|max:100',
            'status'   => 'required|in:available,borrowed',
        ], [
            'name.required'     => 'Nama equipment wajib diisi.',
            'rfid_uid.required' => 'UID Tag RFID wajib diisi.',
            'rfid_uid.unique'   => 'UID Tag RFID sudah digunakan equipment lain.',
            'category.required' => 'Kategori equipment wajib dipilih.',
        ]);

        $equipment->update([
            'name'     => $validated['name'],
            'rfid_uid' => strtoupper(trim($validated['rfid_uid'])),
            'category' => $validated['category'],
            'status'   => $validated['status'],
        ]);

        return redirect()
            ->route('equipment.index')
            ->with('success', 'Data equipment berhasil diperbarui.');
    }

    /**
     * Hapus data equipment.
     */
    public function destroy(Equipment $equipment)
    {
        $equipment->delete();

        return redirect()
            ->route('equipment.index')
            ->with('success', 'Data equipment berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class PemeliharaanController extends Controller
{
    /**
     * Tampilkan daftar equipment dalam status perbaikan/maintenance.
     */
    public function index()
    {
        $maintenanceEquipment = Equipment::where('status', 'maintenance')
            ->orderBy('updated_at', 'desc')
            ->get();

        $allEquipment = Equipment::where('status', '!=', 'maintenance')
            ->orderBy('name')
            ->get();

        $totalMaintenance = $maintenanceEquipment->count();

        return view('pemeliharaan.index', compact('maintenanceEquipment', 'allEquipment', 'totalMaintenance'));
    }

    /**
     * Tandai equipment sebagai sedang dalam perbaikan.
     */
    public function masukPerbaikan(Request $request)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipments,id',
            'catatan'      => 'nullable|string|max:500',
        ], [
            'equipment_id.required' => 'Pilih equipment yang akan diperbaiki.',
            'equipment_id.exists'   => 'Equipment tidak ditemukan.',
        ]);

        $equipment = Equipment::findOrFail($validated['equipment_id']);
        $equipment->update(['status' => 'maintenance']);

        return redirect()->route('pemeliharaan.index')
            ->with('success', "Equipment \"{$equipment->name}\" berhasil ditandai untuk perbaikan.");
    }

    /**
     * Tandai equipment selesai diperbaiki (kembali tersedia).
     */
    public function selesaiPerbaikan($id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->update(['status' => 'available']);

        return redirect()->route('pemeliharaan.index')
            ->with('success', "Equipment \"{$equipment->name}\" telah selesai diperbaiki dan kembali tersedia.");
    }
}


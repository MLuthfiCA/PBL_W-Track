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
        $equipment = Equipment::orderBy('created_at', 'desc')->get();

        return view('equipment.index', compact('equipment'));
    }
}

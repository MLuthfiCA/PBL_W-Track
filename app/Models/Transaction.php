<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'type',
    ];

    // Relasi: Setiap transaksi milik satu equipment
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}
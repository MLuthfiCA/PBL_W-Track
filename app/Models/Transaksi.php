<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'equipment_id',
        'jenis_transaksi',
        'waktu_transaksi',
    ];

    protected $casts = [
        'waktu_transaksi' => 'datetime',
    ];

    /**
     * Setiap transaksi dimiliki oleh satu equipment.
     */
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipments';

    protected $fillable = [
        'rfid_uid',
        'name',
        'category',
        'status',
    ];

    // Relasi: Satu equipment bisa memiliki banyak riwayat transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
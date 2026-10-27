<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('rfid_uid')->unique(); // ID unik Tag RFID (misal: "A3B8129F")
            $table->string('name');              // Nama equipment
            $table->string('category');          // Kategori equipment
            $table->enum('status', ['available', 'borrowed'])->default('available'); // Status barang
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('bibit', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('tanggal_pembelian');
            $table->string('nama_penjual');
            $table->decimal('harga_satuan', 10, 2);
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('bibit');
    }
};

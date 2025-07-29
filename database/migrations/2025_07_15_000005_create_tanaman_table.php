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
        Schema::create('tanaman', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->enum('jenis', ['sayur', 'buah', 'rempah', 'herbal', 'biji', 'kacang', 'umbi', 'hias']);
            $table->integer('stok_bibit')->nullable();
            $table->integer('stok_barang_jadi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanaman');

    }
};

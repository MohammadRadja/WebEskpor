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
        Schema::create('produk', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_tanaman');
            $table->text('deskripsi');
            $table->string('gambar');
            $table->timestamps();

            $table->foreign('id_tanaman')->references('id')->on('tanaman')->cascadeOnDelete();
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};

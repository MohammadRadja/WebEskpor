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
            $table->enum('jenis', ['sayur', 'buah', 'rempah', 'lainnya']);
            $table->integer('stok_panen')->default(0);
            $table->uuid('id_benih');
            $table->enum('sumber', ['internal', 'eksternal']);
            $table->string('sumber_eksternal')->nullable();
            $table->timestamps();

            $table->foreign('id_benih')->references('id')->on('benih')->cascadeOnDelete();
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

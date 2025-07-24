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
            $table->uuid('id_bibit');
            $table->enum('sumber', ['internal', 'eksternal']);
            $table->string('sumber_eksternal')->nullable();
            $table->timestamps();

            $table->foreign('id_bibit')->references('id')->on('bibit')->cascadeOnDelete();
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

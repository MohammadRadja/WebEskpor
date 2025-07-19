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
        Schema::create('petak_kebun', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_kebun');
            $table->uuid('id_tanaman');
            $table->string('nama');
            $table->string('ukuran');
            $table->string('penanggung_jawab');
            $table->string('status');
            $table->date('tanggal_tanam')->nullable();
            $table->integer('jumlah_tanaman')->default(0);
            $table->integer('jumlah_panen')->default(0);
            $table->timestamps();

            $table->foreign('id_kebun')->references('id')->on('kebun')->cascadeOnDelete();
            $table->foreign('id_tanaman')->references('id')->on('tanaman')->cascadeOnDelete();
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('petak_kebun');
    }
};

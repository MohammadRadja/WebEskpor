<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
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
            $table->enum('status', ['aktif', 'non-aktif'])->default('aktif');
            $table->date('tanggal_tanam');
            $table->date('tanggal_panen')->nullable();
            $table->integer('jumlah_tanaman')->nullable();
            $table->integer('jumlah_panen')->nullable();
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

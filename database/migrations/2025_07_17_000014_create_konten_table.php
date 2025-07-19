<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
        {
            Schema::create('konten', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->enum('jenis', ['halaman', 'artikel', 'spanduk'])->default('halaman');
            $table->text('kutipan')->nullable();
            $table->longText('konten')->nullable();
            $table->string('gambar')->nullable();
            $table->string('tautan')->nullable();
            $table->enum('status', ['draf', 'diterbitkan'])->default('draf');
            $table->timestamp('diterbitkan_pada')->nullable();
            $table->uuid('id_penulis');
            $table->timestamps();

            $table->foreign('id_penulis')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konten');
    }
};

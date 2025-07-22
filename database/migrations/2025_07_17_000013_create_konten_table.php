<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('konten', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->enum('jenis', ['halaman', 'artikel', 'spanduk', 'komponen'])->default('halaman');
            $table->text('kutipan');
            $table->longText('konten');
            $table->string('gambar')->nullable();
            $table->string('tautan')->nullable();
            $table->json('meta')->nullable();
            $table->json('media')->nullable();
            $table->enum('status', ['draf', 'terbit'])->default('draf');
            $table->timestamp('diterbitkan_pada');
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produk_eksternal', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_tanaman');
            $table->string('nama_supplier');
            $table->string('kontak');
            $table->enum('jenis_perjanjian', ['konsinyasi', 'pembelian-putus']);
            $table->decimal('komisi', 5, 2)->nullable();
            $table->decimal('harga_satuan', 12, 2);
            $table->integer('jumlah');
            $table->date('tanggal_pembelian');
            $table->decimal('total_harga', 15, 2);
            $table->timestamps();

            $table->foreign('id_tanaman')->references('id')->on('tanaman')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_eksternal');
    }
};

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
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_transaksi');
            $table->uuid('id_produk');
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 10, 2);
            $table->decimal('sub_total', 12, 2);
            $table->timestamps();

            $table->foreign('id_transaksi')->references('id')->on('transaksi')->cascadeOnDelete();
            $table->foreign('id_produk')->references('id')->on('produk')->cascadeOnDelete();
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};

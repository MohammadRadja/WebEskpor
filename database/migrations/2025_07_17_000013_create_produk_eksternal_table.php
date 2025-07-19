<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produk_eksternal', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_produk');
            $table->string('nama_supplier');
            $table->string('kontak');
            $table->enum('jenis_perjanjian', ['konsinyasi', 'pembelian_putus']);
            $table->decimal('komisi', 5, 2)->nullable(); // dalam persen
            $table->decimal('harga_satuan', 10, 2)->nullable();
            $table->integer('jumlah')->nullable();
            $table->date('tanggal_pembelian')->nullable();
            $table->decimal('total_harga', 12, 2)->nullable();
            $table->timestamps();

            $table->foreign('id_produk')->references('id')->on('produk')->cascadeOnDelete();
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

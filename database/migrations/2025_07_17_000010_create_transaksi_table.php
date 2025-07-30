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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_pelanggan');
            $table->string('telepon');
            $table->text('alamat');
            $table->string('negara');
            $table->decimal('biaya_pengiriman', 12, 2)->nullable();
            $table->integer('jumlah')->default(1);
            $table->decimal('total_harga', 15, 2);
            $table->string('no_resi')->nullable();
            $table->enum('jenis_pengiriman', [
                'ditanggung_pembeli',
                'ditanggung_penjual',
                'ditanggung_bersama'
            ])->default('ditanggung_pembeli');
            $table->enum('status', ['menunggu', 'proses', 'dibayar', 'expired', 'gagal'])->default('menunggu');
            $table->string('payment_url')->nullable();
            $table->timestamps();

            $table->foreign('id_pelanggan')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};

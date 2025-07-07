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
    Schema::create('tb_petakan_kebun', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('ukuran');
        $table->string('penanggung_jawab');
        $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');

        // Foreign key ke tb_kebun
        $table->unsignedBigInteger('kebun_id');
        $table->foreign('kebun_id')->references('id')->on('tb_kebun')->onDelete('cascade');

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_petakan_kebun');
    }
};

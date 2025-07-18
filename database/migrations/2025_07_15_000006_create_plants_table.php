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
        Schema::create('plants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->enum('type', ['vegetable', 'fruit', 'spice', 'other']);
            $table->integer('harvest_stock')->default(0);
            $table->uuid('seed_id');
            $table->enum('source', ['internal', 'external']);
            $table->string('external_source')->nullable();
            $table->timestamps();

            $table->foreign('seed_id')->references('id')->on('seeds')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plants');
    }
};

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
    Schema::create('farm_plots', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->uuid('farm_id');
        $table->uuid('plant_id');
        $table->string('name');
        $table->string('size');
        $table->string('responsible_person');
        $table->string('status');
        $table->date('planting_date')->nullable();
        $table->integer('plant_quantity')->default(0);
        $table->integer('harvest_quantity')->default(0);
        $table->timestamps();

        $table->foreign('farm_id')->references('id')->on('farms')->cascadeOnDelete();
        $table->foreign('plant_id')->references('id')->on('plants')->cascadeOnDelete();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farms_plots');
    }
};

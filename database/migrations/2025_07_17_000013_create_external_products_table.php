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
        Schema::create('external_products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('product_id');
            $table->string('supplier_name');
            $table->string('contact');
            $table->enum('agreement_type', ['consignment', 'buyout']);
            $table->decimal('commission', 5, 2)->nullable(); // in percentage
            $table->decimal('unit_price', 10, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->date('purchase_date')->nullable();
            $table->decimal('total_price', 12, 2)->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_products');
    }
};

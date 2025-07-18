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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('buyer_name');
            $table->string('phone');
            $table->text('address');
            $table->string('country');
            $table->decimal('shipping_cost', 10, 2);
            $table->integer('qty');
            $table->decimal('total_price', 12, 2);
            $table->string('payment_proof')->nullable();
            $table->enum('status', ['pending', 'paid', 'shipped', 'done'])->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};

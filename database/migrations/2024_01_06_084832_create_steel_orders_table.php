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
        Schema::create('steel_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')->nullable()->references('id')->on('orders')->onDelete('cascade');
            $table->string('start_weight')->nullable();
            $table->string('end_weight')->nullable();
            $table->string('bol')->nullable();
            $table->string('total_weight_lbs')->nullable();
            $table->string('cx_signature')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('steel_orders');
    }
};

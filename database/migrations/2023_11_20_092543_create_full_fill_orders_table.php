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
        Schema::create('full_fill_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')->nullable()->references('id')->on('orders')->onDelete('cascade');
            $table->string('no_of_passenger')->nullable();
            $table->string('no_of_agri_tyre')->nullable();
            $table->string('no_of_truck_tyre')->nullable();
            $table->string('no_of_other')->nullable();
            $table->string('storage_reg_no')->nullable();
            $table->string('processor_reg_no')->nullable();
            $table->string('customer_signature')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('full_fill_orders');
    }
};

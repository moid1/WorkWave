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
        Schema::create('fulfil_tyres', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('full_fill_orders_id')->nullable();
            $table->foreign('full_fill_orders_id')->nullable()->references('id')->on('full_fill_orders')->onDelete('cascade');
            $table->string('lawnmowers_atvmotorcycle')->nullable();
            $table->string('lawnmowers_atvmotorcyclewithrim')->nullable();
            $table->string('passanger_lighttruck')->nullable();
            $table->string('passanger_lighttruckwithrim')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fulfil_tyres');
    }
};

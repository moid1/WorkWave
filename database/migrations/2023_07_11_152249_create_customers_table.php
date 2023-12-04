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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('address');
            $table->string('phone_no');
            $table->string('poc_name');
            $table->string('passenger_pricing');
            $table->string('truck_pricing')->nullable();
            $table->string('agri_pricing')->nullable();
            $table->string('other')->nullable();
            $table->string('tax')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

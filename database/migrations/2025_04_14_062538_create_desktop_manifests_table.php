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
        Schema::create('desktop_manifests', function (Blueprint $table) {
            $table->id(); // This is your manifest_id
            $table->json('type_of_passenger')->nullable();
            $table->json('type_of_agri_tyre')->nullable();
            $table->json('type_of_truck_tyre')->nullable();
            $table->json('type_of_other')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->string('processor_reg_no')->nullable();
            $table->string('customer_signature')->nullable();
            $table->string('driver_signature')->nullable();
            $table->string('cheque_no')->nullable();
            $table->integer('left_over')->nullable();
            $table->json('radialStuff')->nullable();
            $table->timestamps();
        });
        DB::statement("ALTER TABLE desktop_manifests AUTO_INCREMENT = 1000");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desktop_manifests');
    }
};

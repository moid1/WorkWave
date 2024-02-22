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
        Schema::create('routings', function (Blueprint $table) {
            $table->id();
            $table->string('route_name')->nullable();
            $table->string('order_ids')->nullable();
            $table->boolean('is_route_started')->default(false);
            $table->boolean('is_route_completed')->default(false);
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->foreign('driver_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routings');
    }
};

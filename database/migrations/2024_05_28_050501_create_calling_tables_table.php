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
        Schema::create('calling_tables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('truck_id')->nullable();
            $table->foreign('truck_id')->nullable()->references('id')->on('trucks')->onDelete('cascade');
            $table->text('customer_ids')->nullable();
            $table->string('day')->nullable();
            $table->string('week')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calling_tables');
    }
};

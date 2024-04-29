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
        Schema::table('truck_drivers', function (Blueprint $table) {
           $table->string('users_location')->nullable(); 
            $table->string('users_lat')->nullable(); 
            $table->string('users_long')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('truck_drivers', function (Blueprint $table) {
            //
        });
    }
};

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
        Schema::table('fulfil_tyres', function (Blueprint $table) {
            $table->string('totalPassangerTiresWeight')->nullable();
            $table->string('totalTruckTiresWeight')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fulfil_tyres', function (Blueprint $table) {
            $table->dropColumn('totalPassangerTiresWeight');
            $table->dropColumn('totalTruckTiresWeight');
        });
    }
};

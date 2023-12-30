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
            $table->string('semi_truck')->nullable();
            $table->string('semi_super_singles')->nullable();
            $table->string('semi_truck_with_rim')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fulfil_tyres', function (Blueprint $table) {
            $table->dropColumn('semi_truck');
            $table->dropColumn('semi_super_singles');
            $table->dropColumn('semi_truck_with_rim');
        });
    }
};

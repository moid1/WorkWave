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
        Schema::table('full_fill_orders', function (Blueprint $table) {
            $table->dropColumn('no_of_agri_tyre');
            $table->dropColumn('no_of_passenger');
            $table->dropColumn('no_of_truck_tyre');
            $table->dropColumn('no_of_other');

            $table->longText('type_of_passenger')->nullable();
            $table->longText('type_of_agri_tyre')->nullable();
            $table->longText('type_of_truck_tyre')->nullable();
            $table->longText('type_of_other')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('full_fill_orders', function (Blueprint $table) {
            //
        });
    }
};

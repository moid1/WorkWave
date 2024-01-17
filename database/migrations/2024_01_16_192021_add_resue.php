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
        Schema::table('manager_compare_orders', function (Blueprint $table) {
            $table->longText('reuse_type_of_passenger')->nullable();
            $table->longText('reuse_type_of_agri_tyre')->nullable();
            $table->longText('reuse_type_of_truck_tyre')->nullable();
            $table->longText('reuse_type_of_other')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('manager_compare_orders', function (Blueprint $table) {
            $table->dropColumn('reuse_type_of_passenger');
            $table->dropColumn('reuse_type_of_agri_tyre');
            $table->dropColumn('reuse_type_of_truck_tyre');
            $table->dropColumn('reuse_type_of_other');
        });
    }
};

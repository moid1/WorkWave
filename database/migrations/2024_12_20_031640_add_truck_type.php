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
    Schema::table('trucks', function (Blueprint $table) {
        // Adding the 'truck_type' enum column with a default value
        $table->enum('truck_type', ['box_truck_center', 'semi_truck', 'box_truck_south'])
              ->default('box_truck_center'); // Default value is optional, but it is recommended to avoid null values.
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trucks', function (Blueprint $table) {
            $table->dropColumn('truck_type');
        });
    }
};

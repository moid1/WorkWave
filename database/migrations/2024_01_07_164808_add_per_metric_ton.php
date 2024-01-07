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
        Schema::table('customer_pricings', function (Blueprint $table) {
            $table->string('per_metric_ton')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_pricings', function (Blueprint $table) {
            $table->dropColumn('per_metric_ton');
        });
    }
};

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
            $table->string('left_over')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('full_fill_orders', function (Blueprint $table) {
            $table->dropColumn('left_over');
        });
    }
};

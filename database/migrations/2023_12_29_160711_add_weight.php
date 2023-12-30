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
            $table->string('start_weight')->nullable();
            $table->string('end_weight')->nullable();
            $table->string('cheque_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('full_fill_orders', function (Blueprint $table) {
            $table->dropColumn('start_weight');
            $table->dropColumn('end_weight');
            $table->dropColumn('cheque_no');
        });
    }
};

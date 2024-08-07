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
        Schema::table('trailer_swap_orders', function (Blueprint $table) {
            $table->string('trailer_going')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trailer_swap_orders', function (Blueprint $table) {
            $table->dropColumn('trailer_going');
        });
    }
};

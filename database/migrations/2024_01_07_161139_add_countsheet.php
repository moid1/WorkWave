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
        Schema::table('manifest_p_d_f_s', function (Blueprint $table) {
            $table->string('count_sheet')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('manifest_p_d_f_s', function (Blueprint $table) {
            $table->dropColumn('count_sheet');
        });
    }
};

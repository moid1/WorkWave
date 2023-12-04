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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('mail_address')->nullable();
            $table->string('second_poc')->nullable();
            $table->string('mail_phone')->nullable();
            $table->string('second_mail')->nullable();
            $table->string('charge_type')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('mail_address');
            $table->dropColumn('second_poc');
            $table->dropColumn('mail_phone');
            $table->dropColumn('second_mail');
            $table->dropColumn('charge_type');
        });
    }
};

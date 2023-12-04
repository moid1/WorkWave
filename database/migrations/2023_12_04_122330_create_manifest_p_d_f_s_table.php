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
        Schema::create('manifest_p_d_f_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')->nullable()->references('id')->on('orders')->onDelete('cascade');
            $table->string('generator')->nullable();
            $table->string('transporter')->nullable();
            $table->string('processor')->nullable();
            $table->string('disposal')->nullable();
            $table->string('original_generator')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manifest_p_d_f_s');
    }
};

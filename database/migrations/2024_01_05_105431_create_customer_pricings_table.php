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
        Schema::create('customer_pricings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->nullable()->references('id')->on('customers')->onDelete('cascade');

            $table->string('lawnmowers_atvmotorcycle')->nullable();
            $table->string('lawnmowers_atvmotorcyclewithrim')->nullable();
            $table->string('passanger_lighttruck')->nullable();
            $table->string('passanger_lighttruckwithrim')->nullable();

            $table->string('semi_truck')->nullable();
            $table->string('semi_super_singles')->nullable();
            $table->string('semi_truck_with_rim')->nullable();

            $table->string('ag_med_truck_19_5_skid_steer')->nullable();
            $table->string('ag_med_truck_19_5_with_rim')->nullable();
            $table->string('farm_tractor_last_two_digits')->nullable();

            $table->string('15_5_24')->nullable();
            $table->string('17_5_25')->nullable();
            $table->string('20_5_25')->nullable();
            $table->string('23_5_25')->nullable();
            $table->string('26_5_25')->nullable();
            $table->string('29_5_25')->nullable();
            $table->string('24_00R35')->nullable();
            $table->string('13_00_24')->nullable();
            $table->string('14_00_24')->nullable();
            $table->string('19_5L_24')->nullable();
            $table->string('18_4_30')->nullable();
            $table->string('18_4_38')->nullable();
            $table->string('520_80R46')->nullable();
            $table->string('480_80R50')->nullable();
            $table->string('710_70R43')->nullable();
            $table->string('odd_tire')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_pricings');
    }
};

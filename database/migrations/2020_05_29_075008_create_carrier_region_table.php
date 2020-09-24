<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarrierRegionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carrier_region', function (Blueprint $table) {
            $table->primary(['region_id', 'carrier_id']);

            $table->unsignedBigInteger('carrier_id');
            $table->unsignedBigInteger('region_id');

            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->foreign('carrier_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carrier_region');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Vehicles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigIncrements('vehicle_id')->unsigned()->autoIncrement();
            $table->text('title')->nullable()->collation('utf8_unicode_ci');
            $table->text('description')->nullable()->collation('utf8_unicode_ci');
            // $table->bigInteger('trip_detail_id')->unsigned();
            // $table->foreign('trip_detail_id')
            // ->references('trip_detail_id')
            // ->on('trip_details');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}

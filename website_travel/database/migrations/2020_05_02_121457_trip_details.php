<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TripDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_details', function (Blueprint $table) {
            $table->bigIncrements('trip_detail_id')->unsigned()->autoIncrement();
            $table->datetime('day')->nullable(); 

            $table->bigInteger('province_id')->unsigned();
            $table->foreign('province_id')
            ->references('province_id')
            ->on('provinces');
            $table->bigInteger('trip_id')->unsigned();
            $table->foreign('trip_id')
            ->references('trip_id')
            ->on('trips')
            ->onDelete('cascade'); 

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
        Schema::dropIfExists('trip_details');
    }
}

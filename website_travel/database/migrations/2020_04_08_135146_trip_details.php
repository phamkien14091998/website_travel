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
            $table->dateTime('departure_time');
            $table->string('starting_point',255)->nullable()->collation('utf8_unicode_ci');
            $table->string('departure_location',255)->nullable()->collation('utf8_unicode_ci');
            $table->text('note')->nullable()->collation('utf8_unicode_ci');
            $table->string('cost',20)->nullable();
            $table->bigInteger('trip_id')->unsigned();
            $table->foreign('trip_id')
            ->references('trip_id')
            ->on('trips');

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

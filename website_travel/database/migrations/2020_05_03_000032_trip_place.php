<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TripPlace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_place', function (Blueprint $table) {
            $table->bigIncrements('trip_place_id')->unsigned()->autoIncrement();
            $table->string('time_to')->nullable();  // thời gian đến
            $table->string('time_stay')->nullable(); // thời gian ở lại
            $table->string('vehicle',255)->nullable()->collation('utf8_unicode_ci');
            $table->text('note')->nullable()->collation('utf8_unicode_ci');

            $table->bigInteger('trip_detail_id')->unsigned();
            $table->foreign('trip_detail_id')
            ->references('trip_detail_id')
            ->on('trip_details')
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
        Schema::dropIfExists('trip_place');
    }
}

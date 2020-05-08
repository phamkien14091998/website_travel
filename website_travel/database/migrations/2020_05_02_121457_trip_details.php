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

            $table->string('time_to',255)->nullable();  // thời gian đến
            $table->string('time_stay',255)->nullable(); // thời gian ở lại
            $table->string('vehicle',255)->nullable()->collation('utf8_unicode_ci');
            $table->text('note')->nullable()->collation('utf8_unicode_ci');

            $table->bigInteger('famous_place_id')->unsigned();
            $table->foreign('famous_place_id')
            ->references('famous_place_id')
            ->on('famous_places');
            $table->bigInteger('trip_id')->unsigned();
            $table->foreign('trip_id')
            ->references('trip_id')
            ->on('trips')
            ->onDelete('cascade'); 
            // bảng này để lưu các địa điểm của chuyến đi và mô tả

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

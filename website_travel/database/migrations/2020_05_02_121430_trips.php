<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Trips extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->bigIncrements('trip_id')->unsigned()->autoIncrement();
            $table->string('trip_name',255)->nullable()->collation('utf8_unicode_ci');
            $table->string('description',255)->nullable()->collation('utf8_unicode_ci');
            $table->datetime('day_number')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
            ->references('user_id')
            ->on('users');

            // trips (sẽ tạo đc tên và số ngày của chuyến đi)
            // trip_id
            // trip_name
            // description
            // date_number
            // user_id
            
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
        Schema::dropIfExists('trips');
    }
}

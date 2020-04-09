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
            $table->string('starting_point',255)->nullable()->collation('utf8_unicode_ci');
            $table->string('destination',255)->nullable()->collation('utf8_unicode_ci');
            $table->dateTime('departureday');
            $table->dateTime('enddate');
            $table->integer('number_of_people')->nullable();
            $table->string('cost',20)->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
            ->references('user_id')
            ->on('users');
            
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

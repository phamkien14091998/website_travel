<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Friends extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friends', function (Blueprint $table) {
            $table->bigIncrements('friends')->unsigned()->autoIncrement();

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
            ->references('user_id')
            ->on('users')
            ->onDelete('cascade'); 
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
        Schema::dropIfExists('friends');
    }
}

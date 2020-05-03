<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Collections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->bigIncrements('collection_id')->unsigned()->autoIncrement();
            $table->string('collection_name',100)->nullable()->collation('utf8_unicode_ci');
            
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
            ->references('user_id')
            ->on('users');
            // $table->bigInteger('famous_place_id')->unsigned();
            // $table->foreign('famous_place_id')
            // ->references('famous_place_id')
            // ->on('famous_places');

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
        Schema::dropIfExists('collections');
    }
}

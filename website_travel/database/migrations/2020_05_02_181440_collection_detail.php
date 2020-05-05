<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CollectionDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collection_detail', function (Blueprint $table) {

            $table->bigInteger('famous_place_id')->unsigned();
            $table->foreign('famous_place_id')
            ->references('famous_place_id')
            ->on('famous_places');
            $table->bigInteger('collection_id')->unsigned();
            $table->foreign('collection_id')
            ->references('collection_id')
            ->on('collections')
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
        Schema::dropIfExists('collection_detail');
    }
}

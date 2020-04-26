<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FamousPlaces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('famous_places', function (Blueprint $table) {
            $table->bigIncrements('famous_place_id')->unsigned()->autoIncrement();
            $table->text('title')->nullable()->collation('utf8_unicode_ci');
            $table->text('image')->nullable()->collation('utf8_unicode_ci');
            $table->text('description')->nullable()->collation('utf8_unicode_ci');
            $table->text('date_start')->nullable()->collation('utf8_unicode_ci');
            $table->text('date_end')->nullable()->collation('utf8_unicode_ci');
            $table->bigInteger('province_id')->unsigned();
            $table->foreign('province_id')
            ->references('province_id')
            ->on('provinces');

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
        Schema::dropIfExists('famous_places');
    }
}

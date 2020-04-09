<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Productimage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productimage', function (Blueprint $table) {
            $table->bigIncrements('product_image_id')->unsigned()->autoIncrement();
            $table->text('image_name')->nullable()->collation('utf8_unicode_ci');
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')
            ->references('product_id')
            ->on('products');

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
        Schema::dropIfExists('productimage');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_image', function (Blueprint $table) {
            // $table->bigIncrements('product_image_id')->unsigned()->autoIncrement();
            // $table->text('image_1')->nullable()->collation('utf8_unicode_ci');
            // $table->text('image_2')->nullable()->collation('utf8_unicode_ci');
            // $table->text('image_3')->nullable()->collation('utf8_unicode_ci');
            // $table->bigInteger('product_id')->unsigned();
            // $table->foreign('product_id')
            // ->references('product_id')
            // ->on('products');

            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_image');
    }
}

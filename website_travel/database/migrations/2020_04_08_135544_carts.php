<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Carts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->bigInteger('cart_id')->unsigned();
            $table->integer('quantity')->nullable();
            $table->string('total',20)->nullable()->collation('utf8_unicode_ci');
            $table->bigInteger('product_id')->unsigned();
            $table->foreign('product_id')
            ->references('product_id')
            ->on('products');
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
        Schema::dropIfExists('carts');
    }
}

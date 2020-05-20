<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BillDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_details', function (Blueprint $table) {
            $table->bigIncrements('bill_detail_id')->unsigned()->autoIncrement();
            $table->bigInteger('bill_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->integer('quantity')->nullable();
            $table->string('price',20)->nullable()->collation('utf8_unicode_ci');
            $table->foreign('product_id')
            ->references('product_id')
            ->on('products');
            $table->foreign('bill_id')
            ->references('bill_id')
            ->on('bills');

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
        Schema::dropIfExists('bill_details');
    }
}

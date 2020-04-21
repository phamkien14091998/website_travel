<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Products extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('product_id')->unsigned()->autoIncrement();
            $table->string('product_name',40)->nullable()->collation('utf8_unicode_ci');
            $table->string('price',20)->nullable();
            $table->text('description')->nullable()->collation('utf8_unicode_ci');
            // $table->string('status',20)->nullable()->collation('utf8_unicode_ci');
            $table->integer('quantity')->nullable();
            $table->bigInteger('portfolio_id')->unsigned();
            $table->tinyInteger('flag')->default(1)->comment('0: Hết Hàng');
            $table->string('images',255)->nullable()->collation('utf8_unicode_ci');
            $table->foreign('portfolio_id')
                  ->references('portfolio_id')
                  ->on('products_portfolio')
                  ->onDelete('cascade'); // xoa the loai thi xoa luon san pham

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
        Schema::dropIfExists('products');
    }
}

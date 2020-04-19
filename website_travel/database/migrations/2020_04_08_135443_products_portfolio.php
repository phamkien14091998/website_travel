<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsPortfolio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_portfolio', function (Blueprint $table) {
            $table->bigIncrements('portfolio_id')->unsigned()->autoIncrement();
            $table->string('portfolio_name',50)->nullable()->collation('utf8_unicode_ci');
            // $table->text('description')->nullable()->collation('utf8_unicode_ci');
            // $table->text('image')->nullable();

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
        Schema::dropIfExists('products_portfolio');
    }
}

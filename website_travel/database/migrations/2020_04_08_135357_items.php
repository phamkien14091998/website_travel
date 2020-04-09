<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Items extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('item_id')->unsigned()->autoIncrement();
            $table->string('item_name',200)->nullable()->collation('utf8_unicode_ci');
            $table->integer('amount')->nullable();
            $table->text('description')->nullable()->collation('utf8_unicode_ci');
            $table->bigInteger('post_id')->unsigned();
            $table->foreign('post_id')
            ->references('post_id')
            ->on('posts');

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
        Schema::dropIfExists('items');
    }
}

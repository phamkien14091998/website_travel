<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Comments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('comment_id')->unsigned()->autoIncrement();
            $table->text('content')->nullable()->collation('utf8_unicode_ci');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
            ->references('user_id')
            ->on('users');
            $table->bigInteger('post_id')->unsigned()->nullable();
            $table->foreign('post_id')
            ->references('post_id')
            ->on('posts');
            $table->bigInteger('trip_id')->unsigned()->nullable();
            $table->foreign('trip_id')
            ->references('trip_id')
            ->on('trips');

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
        Schema::dropIfExists('comments');
    }
}

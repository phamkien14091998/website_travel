<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Rating extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rating', function (Blueprint $table) {
            // $table->bigIncrements('rating_id')->unsigned()->autoIncrement();

            $table->integer('point')->nullable(); // số sao mà user đánh giá cho bài viết đó

            // cột này lưu id bài post được đánh giá
            $table->bigInteger('post_id')->unsigned()->nullable(); 
            $table->foreign('post_id')
            ->references('post_id')
            ->on('posts')
            ->onDelete('cascade');

            // lưu id của user đã đánh giá bài viết
            $table->bigInteger('user_id')->unsigned(); 
            $table->foreign('user_id') 
            ->references('user_id')
            ->on('users')
            ->onDelete('cascade'); 

            // cột này lưu id bài post được đánh giá
            $table->bigInteger('famous_place_id')->unsigned()->nullable();
            $table->foreign('famous_place_id')
            ->references('famous_place_id')
            ->on('famous_places')
            ->onDelete('cascade');
            // xóa bảng user hoạc post thì xóa luôn bảng này

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
        Schema::dropIfExists('rating');
    }
}

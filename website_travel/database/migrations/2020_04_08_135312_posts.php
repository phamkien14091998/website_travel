<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Posts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('post_id')->unsigned()->autoIncrement();
            $table->text('title')->nullable()->collation('utf8_unicode_ci');
            $table->text('location')->nullable()->collation('utf8_unicode_ci');
            $table->text('duration')->nullable()->collation('utf8_unicode_ci');
            $table->text('uptime')->nullable()->collation('utf8_unicode_ci');
            $table->text('fare')->nullable()->collation('utf8_unicode_ci');
            $table->string('images',255)->nullable()->collation('utf8_unicode_ci');
            $table->tinyInteger('flag')->default(0)->comment('1: phê duyệt, 2 : hủy bỏ');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
            ->references('user_id')
            ->on('users');
            $table->bigInteger('famous_place_id')->unsigned();
            $table->foreign('famous_place_id')
            ->references('famous_place_id')
            ->on('famous_places')
            ->onDelete('cascade'); // xóa bảng cha thì bảng con cũng mất

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
        Schema::dropIfExists('posts');
    }
}

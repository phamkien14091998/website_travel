<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Notify extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notify', function (Blueprint $table) {
            $table->integer('user_id')->nullable();
            // $table->integer('trip_id')->nullable();
            $table->tinyInteger('flag')->default(0)->comment('0: hiện thông báo , 1: đóng thông báo');
            $table->text('note')->nullable()->collation('utf8_unicode_ci');
            // $table->integer('post_id')->nullable();
            $table->text('url')->nullable()->collation('utf8_unicode_ci');

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
        Schema::dropIfExists('notify');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FamousPlaces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('famous_places', function (Blueprint $table) {
            $table->bigIncrements('famous_place_id')->unsigned()->autoIncrement();
            $table->text('title')->nullable()->collation('utf8_unicode_ci');
            $table->string('images',255)->nullable()->collation('utf8_unicode_ci');
            $table->text('description')->nullable()->collation('utf8_unicode_ci');
            $table->text('date_start')->nullable()->collation('utf8_unicode_ci');
            $table->text('date_end')->nullable()->collation('utf8_unicode_ci');

            $table->text('cultural')->nullable()->collation('utf8_unicode_ci'); // văn hóa
            $table->text('weather')->nullable()->collation('utf8_unicode_ci'); // thời tiết 
            $table->text('vehicle')->nullable()->collation('utf8_unicode_ci'); // phương tiện
            $table->text('cuisine')->nullable()->collation('utf8_unicode_ci'); // ẩm thực
            $table->text('advice')->nullable()->collation('utf8_unicode_ci'); // lời khuyên

            $table->bigInteger('province_id')->unsigned();
            $table->foreign('province_id')
            ->references('province_id')
            ->on('provinces')
            ->onDelete('cascade'); // xoa bảng còn thì xóa ràng buộc bảng cha

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
        Schema::dropIfExists('famous_places');
    }
}

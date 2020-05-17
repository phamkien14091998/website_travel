<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('user_id')->unsigned();
            $table->string('user_name',20)->nullable()->collation('utf8_unicode_ci');
            $table->string('email',40)->nullable()->collation('utf8_unicode_ci');
            $table->string('password',255)->nullable()->collation('utf8_unicode_ci');
            $table->string('full_name',40)->nullable()->collation('utf8_unicode_ci');
            $table->text('avatar')->nullable()->collation('utf8_unicode_ci');
            $table->dateTime('date_of_birth')->nullable();
            $table->integer('gender')->nullable();
            $table->string('hometown',100)->nullable()->collation('utf8_unicode_ci');
            $table->text('hobbies')->nullable()->collation('utf8_unicode_ci');
            $table->tinyInteger('role')->default(0)->comment('1: Admin');
            $table->string('phone_number',20)->nullable()->collation('utf8_unicode_ci');
            $table->string('address',255)->nullable()->collation('utf8_unicode_ci');
            $table->rememberToken();
            // login google
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            // $table->string('social_provider')->nullable();
            
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
        Schema::dropIfExists('users');
    }
}

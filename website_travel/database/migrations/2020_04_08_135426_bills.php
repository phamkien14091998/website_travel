<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Bills extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->bigIncrements('bill_id')->unsigned()->autoIncrement();
            // $table->string('customer_phone',15)->nullable()->collation('utf8_unicode_ci');
            // $table->text('delivery_address')->nullable()->collation('utf8_unicode_ci');
            // $table->string('status',30)->nullable()->collation('utf8_unicode_ci');
            $table->text('note')->nullable()->collation('utf8_unicode_ci');
            $table->string('form_of_delivery',100)->nullable()->collation('utf8_unicode_ci');
            // $table->string('payment',30)->nullable()->collation('utf8_unicode_ci');
            // $table->text('payment_info')->nullable()->collation('utf8_unicode_ci');
            // $table->string('security',20)->nullable()->collation('utf8_unicode_ci');
            $table->string('ship_fee',20)->nullable()->collation('utf8_unicode_ci');
            $table->integer('total')->nullable();
            $table->text('form_of_payment')->nullable()->collation('utf8_unicode_ci');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
            ->references('user_id')
            ->on('users');

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
        Schema::dropIfExists('bills');
    }
}

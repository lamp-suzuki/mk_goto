<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manages_id'); // 店舗アカウント
            $table->foreign('manages_id')->references('id')->on('manages');

            $table->string('shop_name');
            $table->string('plan_name');
            $table->string('genre_name');

            $table->date('date');
            $table->time('time');
            $table->integer('customers');

            $table->string('name');
            $table->string('furigana');
            $table->string('email');
            $table->string('tel');
            $table->text('memo')->nullable();

            $table->integer('payment');

            $table->string('zipcode_1')->nullable();
            $table->string('pref_1')->nullable();
            $table->string('address1_1')->nullable();
            $table->string('address2_1')->nullable();

            $table->string('zipcode_2')->nullable();
            $table->string('pref_2')->nullable();
            $table->string('address1_2')->nullable();
            $table->string('address2_2')->nullable();

            $table->text('waypoints')->nullable();

            $table->integer('amount');
            $table->boolean('cancel')->default(0);

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
        Schema::dropIfExists('orders');
    }
}

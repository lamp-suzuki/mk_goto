<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manages_id'); // 店舗アカウント
            $table->foreign('manages_id')->references('id')->on('manages');

            $table->unsignedBigInteger('categories_id'); // カテゴリ
            $table->foreign('categories_id')->references('id')->on('categories');

            $table->unsignedBigInteger('genres_id'); // genre
            $table->foreign('genres_id')->references('id')->on('genres');

            $table->string('name');
            $table->integer('price');

            $table->text('time');

            $table->text('explanation')->nullable();

            $table->string('status');

            $table->integer('sort_id')->default(1);

            $table->string('thumbnail_1')->nullable();
            $table->string('caption_1')->nullable();
            $table->string('thumbnail_2')->nullable();
            $table->string('caption_2')->nullable();
            $table->string('thumbnail_3')->nullable();
            $table->string('caption_3')->nullable();

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
        Schema::dropIfExists('products');
    }
}

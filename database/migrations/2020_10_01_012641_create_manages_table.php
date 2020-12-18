<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // アカウント名
            $table->string('domain')->unique(); // ドメイン名
            $table->text('description')->nullable(); // サイト説明文
            $table->string('logo')->nullable(); // サイト説明文
            $table->string('email')->unique(); // メールアドレス
            $table->timestamp('email_verified_at')->nullable();
            $table->string('tel'); // 電話番号
            $table->string('fax')->nullable(); // fax
            $table->string('password'); // パスワード

            $table->boolean('show_hide')->default(1); // 表示非表示

            $table->rememberToken();
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
        Schema::dropIfExists('manages');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');

            $table->string('phone')->unique()->comment('手机号');
            $table->string('name')->comment('用户名');
            $table->string('avatar')->comment('头像');
            $table->string('password')->comment('密码');
            $table->string('id_card')->nullable()->comment('身份证');
            $table->unsignedDecimal('gift_amount')->index()->default(0)->comment('赠送礼物金额');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

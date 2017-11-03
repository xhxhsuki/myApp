<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('avatar')->nullable();
            $table->string('name')->nullable();
            $table->string('phone', 20)->unique();
            $table->string('password')->nullable();
            $table->string('position');  //坐标
            $table->string('nickname');  //昵称
            $table->string('head_pic');  //头像
            $table->string('description');  //签名
            $table->string('verify_pic');  //审核图片

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
        Schema::dropIfExists('users');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actives', function (Blueprint $table) {
            $table->increments('id');   // ID
            $table->string('active_title');    // 活动标题
            $table->string('active_pic');    // 活动封面
            $table->string('active_store_id');    // 活动链接id
            $table->integer('active_order');    // 活动排序
            $table->tinyInteger('active_is_public');   // 活动是否公开   0: 公开 1：不公开
            $table->timestamps();   // // created_at 和 updated_at列
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actives');
    }
}

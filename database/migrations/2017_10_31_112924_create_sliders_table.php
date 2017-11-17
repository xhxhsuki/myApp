<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->increments('id');   // ID
            $table->string('pic');    // 图片
            $table->string('url');    //  跳转链接
            $table->tinyInteger('cate');   // 是否公开
            $table->tinyInteger('forwhat');   // 种类  0 店铺活动 1 文章  2店铺列表
            $table->tinyInteger('slider_is_public');   // 是否公开
            $table->timestamps();   //   created_at 和 updated_at列
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sliders');
    }
}

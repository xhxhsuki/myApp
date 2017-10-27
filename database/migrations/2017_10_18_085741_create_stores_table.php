<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');   // 店铺ID
            $table->string('category_id');    // 店铺分类id
            $table->string('store_title');    // 店铺名称
            $table->string('store_subtitle');    // 店铺副标题
            $table->text('store_description');    // 店铺摘要
            $table->string('store_position');    //店铺坐标
            $table->string('store_address');    //店铺地址
            $table->string('store_tel');    //店铺电话
            $table->string('store_business_hours');    //店铺营业时间
            $table->string('store_pics');    // 店铺封面
            $table->tinyInteger('store_is_public');   // 店铺是否公开   0: 公开 1：不公开
            $table->longText('store_content');    // 店铺内容
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
        Schema::dropIfExists('stores');
    }
}

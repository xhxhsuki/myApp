<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');   // 产品ID
            $table->string('store_id');    // 所属店id
            $table->string('product_name');    // 产品名称
            $table->string('product_price');    // 产品副标题
            $table->text('product_description');    // 产品摘要
            $table->string('product_address');    //产品地址
            $table->string('product_tel');    //产品电话
            $table->string('product_business_hours');    //产品营业时间
            $table->string('product_pics');    // 产品封面
            $table->tinyInteger('product_is_public');   // 产品是否公开   0: 公开 1：不公开
            $table->longText('product_content');    // 产品内容
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
        Schema::dropIfExists('products');
    }
}

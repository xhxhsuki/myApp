<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreCategorysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_categorys', function (Blueprint $table) {
            $table->increments('id');   // ID
            $table->string('store_category_name');    // 分类名称
            $table->tinyInteger('store_category_is_public');   // 是否公开   0: 公开 1：不公开
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
        Schema::dropIfExists('store_categorys');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');   // 文章ID
            $table->string('article_title');    // 文章标题
            $table->text('article_description');    // 文章摘要
            $table->string('article_pic');    // 文章封面
            $table->bigInteger('article_views');    // 文章查看次数
            $table->tinyInteger('article_is_public');   // 文章是否公开   0: 公开 1：不公开
            $table->longText('article_content');    // 文章内容
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
        Schema::dropIfExists('articles');
    }
}

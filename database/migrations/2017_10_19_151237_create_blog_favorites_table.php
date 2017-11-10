<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_favorites', function (Blueprint $table) {
            $table->increments('id');   // ID
            $table->bigInteger('blog_id');    // 被收藏帖子id
            $table->bigInteger('user_id');    // 用户id
            $table->tinyInteger('is_favorite');   // 是否收藏   0: 公开 1：不公开
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
        Schema::dropIfExists('blog_favorites');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogAttitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_attitudes', function (Blueprint $table) {
            $table->increments('id');   // ID
            $table->bigInteger('comment_id');    // 被点赞帖子id
            $table->bigInteger('user_id');    // 点赞用户id
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
        Schema::dropIfExists('blog_attitudes');
    }
}

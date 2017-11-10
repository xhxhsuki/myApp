<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->increments('id');   // ID
            $table->tinyInteger('cate_id');    // 点赞分类  2=>车友圈 3=>帖子
            $table->bigInteger('pid');    // 被点赞回复/车友圈id
            $table->bigInteger('user_id');    // 点赞用户id
            $table->tinyInteger('is_like');    // 点赞状态 0=>点赞  1=>取消点赞
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
        Schema::dropIfExists('likes');
    }
}

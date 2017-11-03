<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');   // ID
            $table->tinyInteger('cate_id');    // 评论分类 1=>门店  2=>帖子  3=>车友圈
            $table->bigInteger('pid');    // 被评论门店/帖子/车友圈id
            $table->bigInteger('user_id');    // 评论用户id
            $table->text('blog_comment_text');    // 评论内容
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
        Schema::dropIfExists('comments');
    }
}

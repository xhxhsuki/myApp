<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoterieCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coterie_comments', function (Blueprint $table) {
            $table->increments('id');   // ID
            $table->bigInteger('coterie_id');    // 被评论车友圈id
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
        Schema::dropIfExists('coterie_comments');
    }
}

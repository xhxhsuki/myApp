<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoterieAttitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coterie_attitudes', function (Blueprint $table) {
            $table->increments('id');   // ID
            $table->bigInteger('coterie_id');    // 被点赞车友圈id
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
        Schema::dropIfExists('coterie_attitudes');
    }
}

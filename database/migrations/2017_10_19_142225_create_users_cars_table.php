<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_cars', function (Blueprint $table) {
            $table->increments('id');   // ID
            $table->bigInteger('user_id');    //  用户id
            $table->bigInteger('car_model_id');    // 型号id
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
        Schema::dropIfExists('users_cars');
    }
}

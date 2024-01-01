<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('stage')->default(1);
            $table->string('season')->nullable();
            $table->string('contributor')->nullable();
            $table->integer('stage1_id')->unsigned();
            $table->integer('stage2_id')->unsigned();
            $table->integer('stage3_id')->unsigned();
            $table->integer('stage4_id')->unsigned();
            $table->integer('stage5_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}

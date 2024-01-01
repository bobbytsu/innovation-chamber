<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStage5sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stage5s', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('post_img')->nullable();
            $table->text('description')->nullable();
            $table->string('post_file')->nullable();
            $table->integer('review_id')->unsigned();
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
        Schema::dropIfExists('stage5s');
    }
}

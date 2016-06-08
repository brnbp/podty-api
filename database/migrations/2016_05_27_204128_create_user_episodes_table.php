<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_episodes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_feed_id');
            $table->integer('episode_id')->unsigned();
            $table->boolean('hide');
            $table->smallInteger('heard');
            $table->boolean('downloaded');
            $table->integer('paused_at');
            $table->foreign('episode_id')->references('id')->on('episodes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_episodes');
    }
}

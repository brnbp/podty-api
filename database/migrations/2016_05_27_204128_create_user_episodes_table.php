<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->integer('user_feed_id')->unsigned()->index();
            $table->integer('episode_id')->unsigned()->index();
            $table->integer('paused_at');
            $table->timestamps();
            $table->foreign('user_feed_id')->references('id')->on('user_feeds')->onDelete('cascade');
            $table->foreign('episode_id')->references('id')->on('episodes');

            $table->unique(['user_feed_id', 'episode_id']);
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

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
            $table->integer('user_feed_id')->unsigned()->index();
            $table->integer('episode_id')->unsigned()->index();
            $table->integer('paused_at');
            $table->timestamps();
            $table->foreign('user_feed_id')->references('id')->on('user_feeds')->onDelete('cascade');
            $table->foreign('episode_id')->references('id')->on('episodes');

            // determina que nao podera haver dois registros iguais na tabela,
            // dois registros com a mesma relacao de user_feed_id e episode_id
            // um user só podera ter um unico registro de determinado episodio para determinado feed
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

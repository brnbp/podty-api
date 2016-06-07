<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feeds', function(Blueprint $table){
            $table->increments('id');
            $table->string('name')->index();
            $table->string('url')->index();
            $table->string('thumbnail_30');
            $table->string('thumbnail_60');
            $table->string('thumbnail_100');
            $table->string('thumbnail_600');
            $table->integer('total_episodes');
            $table->timestamp('last_episode_at');
            $table->timestamps();
            $table->unique('url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('feeds');
    }
}

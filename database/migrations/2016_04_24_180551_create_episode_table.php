<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpisodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episodes', function(Blueprint $table){
            $table->increments('id')->unique();
            $table->integer('feed_id');
            $table->string('title');
            $table->string('link');
            $table->dateTime('published_date');
            $table->mediumText('content');
            $table->string('media_url')->unique();
            $table->integer('media_length');
            $table->string('media_type');
            $table->index('feed_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('episodes');
    }
}

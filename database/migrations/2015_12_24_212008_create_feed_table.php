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
            $table->string('name');
            $table->string('url');
            $table->string('thumbnail_30');
            $table->string('thumbnail_60');
            $table->string('thumbnail_100');
            $table->string('thumbnail_600');
            $table->timestamps();
            $table->unique('url');
            $table->index(['name', 'url']);
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

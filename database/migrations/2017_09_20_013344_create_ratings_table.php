<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('rating_types')->onDelete('cascade');
            
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->integer('content_id')->unsigned();
            
            $table->float('rate')->unsigned();
            $table->timestamps();
            
            $table->unique(['type_id', 'user_id', 'content_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ratings');
    }
}

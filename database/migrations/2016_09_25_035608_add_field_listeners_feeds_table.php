<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldListenersFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('feeds', function ($table) {
            $table->integer('listeners')->nullable()->default(0)->after('last_episode_at');
            ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feeds', function ($table) {
            $table->dropColumn('listeners');
        });
    }
}

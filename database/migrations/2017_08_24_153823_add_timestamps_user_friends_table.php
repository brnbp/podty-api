<?php

use Illuminate\Database\Migrations\Migration;

class AddTimestampsUserFriendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_friends', function ($table) {
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
        Schema::table('user_friends', function ($table) {
            $table->dropColumn('created_at');
        });
        Schema::table('user_friends', function ($table) {
            $table->dropColumn('updated_at');
        });
    }
}

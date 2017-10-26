<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsEpisodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('episodes', function (Blueprint $table) {
            $table->string('image')->nullable()->after('content');
            $table->string('duration', 50)->nullable()->after('image');
            $table->string('summary')->nullable()->after('published_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('episodes', function (Blueprint $table) {
            $table->dropColumn(['image', 'duration', 'summary']);
        });
    }
}

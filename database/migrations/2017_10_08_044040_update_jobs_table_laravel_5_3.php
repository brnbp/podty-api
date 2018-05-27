<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateJobsTableLaravel53 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn('reserved');
            $table->index(['queue', 'reserved_at']);
        });

        Schema::table('failed_jobs', function (Blueprint $table) {
            $table->longText('exception')->nullable()->after('payload');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->tinyInteger('reserved')->default(0)->unsigned();
            $table->index(['queue', 'reserved', 'reserved_at']);
        });

        Schema::table('failed_jobs', function (Blueprint $table) {
            $table->dropColumn('exception');
        });
    }
}

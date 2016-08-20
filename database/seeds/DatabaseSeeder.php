<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('user_episodes')->truncate();
        DB::table('user_feeds')->truncate();
        DB::table('users')->truncate();
        DB::table('episodes')->truncate();
        DB::table('feeds')->truncate();
        DB::table('jobs')->truncate();
        DB::table('customers')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call('CustomersTableSeeder');
        $this->call('FeedsTableSeeder');
        $this->call('EpisodesTableSeeder');
        $this->call('UsersTableSeeder');
        $this->call('UserFeedsTableSeeder');
        $this->call('UserEpisodesTableSeeder');
        $this->call('JobsTableSeeder');
    }
}

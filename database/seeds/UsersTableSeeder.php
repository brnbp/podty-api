<?php
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'username' => 'bruno2546',
                'email' => 'bruno2546@brnbp.me',
                'password' => bcrypt('bruno2546'),
                'remember_token' => md5('bruno2546'),
                'friends_count' => 1,
                'podcasts_count' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
            [
                'username' => 'brnbp',
                'email' => 'brnbp@brnbp.me',
                'password' => bcrypt('brnbp'),
                'remember_token' => md5('brnbp'),
                'friends_count' => 1,
                'podcasts_count' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        ]);
    }
}

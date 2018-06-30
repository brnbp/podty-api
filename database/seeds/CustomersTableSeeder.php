<?php
use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->insert([
            [
                'username' => 'brnbp',
                'email' => 'brnbp@brnbp.me',
                'password' => bcrypt('brnbp'),
            ]
        ]);
    }
}

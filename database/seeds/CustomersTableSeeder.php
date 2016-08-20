<?php
use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * User: brnbp
 * Date: 6/14/16
 * Time: 10:21 PM
 */
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

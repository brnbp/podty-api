<?php

use Illuminate\Database\Seeder;

class RatingTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rating_types')->insert([
            'type' => 'episode',
        ]);
        DB::table('rating_types')->insert([
            'type' => 'feeds',
        ]);
    }
}

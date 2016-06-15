<?php
use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * User: brnbp
 * Date: 6/14/16
 * Time: 10:20 PM
 */
class JobsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobs = [
            [
                'queue' => 'feeds',
                'payload' => json_encode(['data' => ['command' => 'payload one']]),
                'attempts' => 2,
                'reserved' => 1,
            ],
            [
                'queue' => 'feeds',
                'payload' => json_encode(['data' => ['command' => 'payload two']]),
                'attempts' => 1,
                'reserved' => 1,
            ],
            [
                'queue' => 'feeds',
                'payload' => json_encode(['data' => ['command' => 'payload three']]),
                'attempts' => 0,
                'reserved' => 0,
            ],
            [
                'queue' => 'feeds',
                'payload' => json_encode(['data' => ['command' => 'payload four']]),
                'attempts' => 0,
                'reserved' => 0,
            ],
            [
                'queue' => 'feeds',
                'payload' => json_encode(['data' => ['command' => 'payload five']]),
                'attempts' => 0,
                'reserved' => 0,
            ],
            [
                'queue' => 'feeds',
                'payload' => json_encode(['data' => ['command' => 'payload six']]),
                'attempts' => 0,
                'reserved' => 0,
            ],
            [
                'queue' => 'feeds',
                'payload' => json_encode(['data' => ['command' => 'payload seven']]),
                'attempts' => 0,
                'reserved' => 0,
            ]
        ];

        foreach ($jobs as $job) {
            DB::table('jobs')->insert($job);
        }    
    }
}

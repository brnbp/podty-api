<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class QueueController extends Controller
{
    /** @var string TABLE_NAME nome da tabela de queue */
    const TABLE_NAME = 20;

    /** @var array $select_fields fields to return on query */
    private $select_fields = ['id', 'queue', 'payload', 'attempts', 'reserved'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table(self::TABLE_NAME)
            ->select($this->select_fields)
            ->take(15)
            ->get();

        $returned = [];

        if(!$data){
            return $returned;
        }

        foreach ($data as $job) {
            $returned[] = [
                'id' => $job->id,
                'queue' => $job->queue,
                'payload' => json_decode($job->payload, true)['data']['command'],
                'attempts' => $job->attempts,
                'reserved' => $job->reserved
            ];
        }

        return $returned;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reserved()
    {
        return DB::table(self::TABLE_NAME)
            ->select($this->select_fields)
            ->where('reserved', 1)
            ->take(15)
            ->get();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = DB::table(self::TABLE_NAME)
            ->where([
                ['id', $id],
                ['reserved', 0]
            ])
            ->delete();
        return $deleted ? response('', 200) : response('', 400);
    }
}

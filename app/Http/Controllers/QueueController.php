<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class QueueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('jobs')
            ->select(['id', 'queue', 'payload', 'attempts', 'reserved'])
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
        return DB::table('jobs')
            ->select(['id', 'queue', 'payload', 'attempts', 'reserved'])
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
        $deleted = DB::table('jobs')
            ->where([
                ['id', $id],
                ['reserved', 0]
            ])
            ->delete();
        return $deleted ? response('', 200) : response('', 400);
    }
}

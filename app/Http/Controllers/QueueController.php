<?php
namespace App\Http\Controllers;

use App\Services\Filter;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class QueueController extends Controller
{
    /** @var string TABLE_NAME nome da tabela de queue */
    const TABLE_NAME = 'jobs';

    /** @var string NOT_RESERVED queue nao reservada */
    const NOT_RESERVED = 0;

    /** @var string RESERVED queue reservada */
    const RESERVED = 1;

    /** @var array $select_fields fields to return on query */
    private $select_fields = ['id', 'queue', 'payload', 'attempts', 'reserved'];

    /**
     * Display jobs in queue to process
     */
    public function index()
    {
        $Filter = new Filter();

        if ($Filter->validateFilters() === false) {
            return (new Response())->setStatusCode(400);
        }

        $data = DB::table(self::TABLE_NAME)
            ->select($this->select_fields)
            ->skip($Filter->offset)
            ->take($Filter->limit)
            ->get();

        return $this->formatResponse($data);
    }

    /**
     * Display jobs that are reserved to process
     */
    public function reserved()
    {
        $data = DB::table(self::TABLE_NAME)
            ->select($this->select_fields)
            ->where('reserved', self::RESERVED)
            ->take(10)
            ->get();

        return $this->formatResponse($data);
    }

    /**
     * Remove job from queue, except if its not reserved to process
     * @param integer $id id da queue
     * @return Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = DB::table(self::TABLE_NAME)
            ->where([
                ['id', $id],
                ['reserved', self::NOT_RESERVED]
            ])
            ->delete();

        return (new Response())->setStatusCode($deleted ? 200 : 400);
    }

    /**
     * Formata retorno de solicitação para melhorar visualização
     * @param array|boolean $resultQuery retorno da query
     * @return array retorna array formatado ou vazio se nao foi passado nenhum resultado
     */
    private function formatResponse($resultQuery)
    {
        $returned = [];

        if(!$resultQuery){
            return $returned;
        }

        foreach ($resultQuery as $job) {
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
}

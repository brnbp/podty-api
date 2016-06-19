<?php
namespace App\Http\Controllers;

use App\Filter\Filter;
use App\Transform\QueueTransformer;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * Class QueueController
 *
 * @author Bruno Pereira <bruno9pereira@gmail.com>
 */
class QueueController extends ApiController
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
     *
     * @param Filter           $filter
     *
     * @param QueueTransformer $queueTransformer
     *
     * @return array|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Filter $filter, QueueTransformer $queueTransformer)
    {
        if ($filter->validateFilters() === false) {
            return $this->respondInvalidFilter();
        }

        $data = DB::table(self::TABLE_NAME)
            ->select($this->select_fields)
            ->skip($filter->offset)
            ->take($filter->limit)
            ->get();

        if(empty($data)){
            return $this->respondNotFound();
        }

        return $queueTransformer->transformCollection($data);
    }

    /**
     * Display jobs that are reserved to process
     */
    public function failed()
    {
        $data = DB::table('failed_jobs')
            ->take(10)
            ->get();

        if (empty($data)) {
            return $this->respondNotFound();
        }

        return $data;
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

        return (new Response)->setStatusCode($deleted ? 200 : 400);
    }
}

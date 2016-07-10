<?php
namespace App\Http\Controllers;

use App\Filter\Filter;
use App\Repositories\QueueRepository;
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

        $data = QueueRepository::all($filter);
        $data = $data->toArray();

        if(empty($data)){
            return $this->respondNotFound();
        }

        return $this->respondSuccess($queueTransformer->transformCollection($data));
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

        return $this->respondSuccess($data);
    }

    /**
     * Remove job from queue, except if its not reserved to process
     * @param integer $id id da queue
     * @return Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = QueueRepository::drop($id);

        return (new Response)->setStatusCode($deleted ? 200 : 400);
    }
}

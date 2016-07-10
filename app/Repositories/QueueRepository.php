<?php
namespace App\Repositories;


use App\Filter\Filter;
use App\Models\Queue;
use Illuminate\Database\Eloquent\Collection;

class QueueRepository
{
    public static function all(Filter $filter)
    {
        return Queue::select(['id', 'queue', 'payload', 'attempts', 'reserved'])
            ->skip($filter->offset)
            ->take($filter->limit)
            ->get();
    }

    public static function drop($id)
    {
        return Queue::whereId($id)->whereReserved(Queue::NOT_RESERVED)->delete();
    }
}

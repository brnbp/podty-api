<?php
namespace App\Transform;

/**
 * Class QueueTransformer
 *
 * @package App\Transform
 */
class QueueTransformer extends TransformerAbstract
{
    /**
     * Transforma uma queue para um retorno padrao
     * @param array $queue
     *
     * @return array
     */
    public function transform($queue)
    {
        return [
            'id' => $queue->id,
            'payload' => json_decode($queue->payload, true)['data']['command'],
            'attempts' => $queue->attempts,
            'reserved' => $queue->reserved
        ];

    }
}

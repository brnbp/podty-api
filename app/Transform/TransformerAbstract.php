<?php

namespace App\Transform;

/**
 * Class Transformer
 *
 * @package App\Transform
 */
abstract class Transformer
{
    /**
     * Itera sob um array de itens e transforma cada item
     * @param array $itens
     *
     * @return array
     */
    public function transformCollection(array $itens)
    {
        return array_map([$this, 'transform'], $itens);
    }

    public abstract function transform(array $item);
}

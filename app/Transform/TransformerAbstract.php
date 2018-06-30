<?php
namespace App\Transform;

/**
 * Class Transformer
 *
 * @package App\Transform
 */
abstract class TransformerAbstract
{
    public function transformMany(array $itens)
    {
        return array_map([$this, 'transform'], $itens);
    }

    abstract public function transform($item);
}

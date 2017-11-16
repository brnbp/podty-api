<?php
namespace App\Filter;

abstract class FilterAbstract
{
    /** @var integer $limit */
    public $limit = 5;

    /** @var integer $offset */
    public $offset = 0;

    /** @var string $order */
    public $order = 'DESC';

    /** @var string $term */
    public $term;

    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    abstract public function validateFilters();
}

<?php
/**
 * Created by PhpStorm.
 * User: bruno2546
 * Date: 09/05/16
 * Time: 21:19
 */

namespace App\Services;

use Illuminate\Http\Request;

class Filter
{
    public $limit = 5;
    public $offset = 0;
    public $order = 'DESC';

    public function validateFilters()
    {
        if (!Request()->getQueryString()) {
            return true;
        }

        $filters = $this->arrayFilter(
            $this->getAssocArray(
                explode('&', Request()->getQueryString()
                )
            )
        );

        if ($filters === false) {
            return false;
        }

        if (isset($filters['limit'])) {
            if (is_numeric($filters['limit']) == false) {
                return false;
            }

            if ($filters['limit'] > 10) {
                $filters['limit'] = 10;
            }
        }

        if (isset($filters['offset']) && !is_numeric($filters['offset'])) {
            return false;
        }

        if (empty($filters) == false) {
            foreach($filters as $name => $value) {
                $this->$name = $value;
            }
        }

        return true;
    }

    /**
     * Make assoc array
     * @param $parameter
     * @return array
     */
    private function getAssocArray(array $parameter)
    {
        $master_filter = [];
        foreach ($parameter as $filters) {
            $filter = explode('=', $filters);
            $master_filter[$filter[0]] = $filter[1];
        }

        return $master_filter;
    }

    /**
     * Verify if the filters on query string are valid
     * @param $array
     * @return array content valid filters
     */
    private function arrayFilter(array $array)
    {
        $filters_allowed = array_flip([
            'limit',
            'offset',
            'order'
        ]);

        $ret = array_intersect_key($array, $filters_allowed);

        if (count($ret) != count($array)) {
            return false;
        }

        return array_intersect_key($array, $filters_allowed);
    }
}

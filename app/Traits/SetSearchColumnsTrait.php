<?php

namespace App\Traits;

/**
 * Copyright  (c) - Narayan Adhikary -  2020.  https://wovosoft.com
 */
trait SetSearchColumnsTrait
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder Query Builder Instance
     * @param array $cols List of Columns associated with the Query Builder
     * @param string $query Because We can pass only string to the SQL Query, it should be a query string.
     * @return mixed    No Need to Catch the returned output, because the builder is passed by reference.
     */
    private function setSearchColumns(&$builder, array $cols = [], string $query = '')
    {
        $index = -1;
        foreach ($cols as $col) {
            $index++;
            //when first index !0=1 (true)
            if (!$index) {
                $builder->where($col, 'LIKE', $query);
            } else {
                $builder->orWhere($col, 'LIKE', $query);
            }
        }
        return $builder;
    }
}



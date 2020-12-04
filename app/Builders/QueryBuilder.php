<?php

namespace App\Builders;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class QueryBuilder extends Builder
{
    /**
     * @param array $options
     * @param string|null $date_range_by
     * @return LengthAwarePaginator
     */
    public function datatable(array $options = [], ?string $date_range_by = "created_at"): LengthAwarePaginator
    {
        $options = array_merge([
            'orderBy' => 'id',
            'order' => 'desc',
            'filter' => null,
            'filter_type' => 'or',
            'columns' => ['*'],
            'per_page' => env('PER_PAGE') ?? 15,
            'search_columns' => []
        ], Arr::where($options, fn($v, $k) => !!$v));


        if (isset($options['search_columns']['starting_date'])
            && $options['search_columns']['starting_date']
            && isset($options['search_columns']['ending_date'])
            && $options['search_columns']['ending_date']) {
            $this->whereBetween("$date_range_by", [$options['search_columns']['starting_date'], $options['search_columns']['ending_date']]);
            if ($options["filter"] && $options["columns"]) {
                $this->filter($options["filter"], $options["columns"], $options["filter_type"], true);
            }
        } elseif (isset($options['search_columns']['starting_date']) && $options['search_columns']['starting_date'] && !isset($options['search_columns']['ending_date'])) {
            $this->whereDate("$date_range_by", "=", $options['search_columns']['starting_date']);
            if ($options["filter"] && $options["columns"]) {
                $this->filter($options["filter"], $options["columns"], $options["filter_type"], true);
            }
        } elseif (!isset($options['search_columns']['starting_date']) && isset($options['search_columns']['ending_date']) && $options['search_columns']['ending_date']) {
            $this->whereDate("$date_range_by", "=", $options['search_columns']['ending_date']);
            if ($options["filter"] && $options["columns"]) {
                $this->filter($options["filter"], $options["columns"], $options["filter_type"], true);
            }
        } else {
            if ($options["filter"] && $options["columns"]) {
                $this->filter($options["filter"], $options["columns"], $options["filter_type"], false);
            }
        }

        $scls_without_dates = $options['search_columns'];
        if (!empty($scls_without_dates['starting_date'])) {
            unset($scls_without_dates['starting_date']);
        }
        if (!empty($scls_without_dates['ending_date'])) {
            unset($scls_without_dates['ending_date']);
        }
        foreach ($scls_without_dates as $key => $value) {
            $this->where($key, '=', $value);
        }

        return $this
            ->orderBy($options["orderBy"], $options["order"])
            ->paginate($options['per_page']);
    }

    /**
     * @param Request | array $request [filter='string', filter_type='or|and', per_page = 15, orderBy='id', order='desc|asc',columns=['*']]
     * @param string $date_range_by
     * @return LengthAwarePaginator
     */
    public function defaultDatatable($request, $date_range_by = "created_at"): LengthAwarePaginator
    {
        return $this->datatable($request instanceof Request ? [
            "filter" => $request->post("filter"),
            "filter_type" => $request->post("filter_type"),
            "per_page" => $request->post("per_page"),
            "orderBy" => $request->post("orderBy"),
            "order" => $request->post("order"),
            "columns" => $request->post('columns') ?? ['*'],
            "search_columns" => $request->post("search_columns")
        ] : $request, $date_range_by);
    }

    public function getItem(int $id)
    {
        return $this->find($id);
    }

    /**
     * @param string|null $filter Query String
     * @param array $columns Columns to be queried
     * @param string $filter_type and | or
     * @param bool $nested
     * @return $this
     */
    public function filter(string $filter = null, array $columns = [], string $filter_type = "or", bool $nested = false): QueryBuilder
    {
        if ($filter && is_array($columns) && count($columns)) {
            if ($columns === ['*']) {
                $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getModel()->getTable());
            }

            if (trim($filter_type) === "or") {
                if ($nested) {
                    $this->where(function ($q) use ($filter, $columns) {
                        for ($x = 0; $x < count($columns); $x++) {
                            if ($x > 0) {
                                $q->orWhere($columns[$x], "LIKE", "%" . trim($filter) . "%");
                            } else {
                                $q->where($columns[$x], "LIKE", "%" . trim($filter) . "%");
                            }
                        }
                    });
                } else {
                    for ($x = 0; $x < count($columns); $x++) {
                        if ($x > 0) {
                            $this->orWhere($columns[$x], "LIKE", "%" . trim($filter) . "%");
                        } else {
                            $this->where($columns[$x], "LIKE", "%" . trim($filter) . "%");
                        }
                    }
                }

            } elseif (trim($filter_type) === 'and') {
                if ($nested) {
                    $this->where(function ($q) use ($filter, $columns) {
                        foreach ($columns as $column) {
                            $q->where($column, "LIKE", "%" . trim($filter) . "%");
                        }
                    });
                } else {
                    foreach ($columns as $column) {
                        $this->where($column, "LIKE", "%" . trim($filter) . "%");
                    }
                }
            }
        }
        return $this;
    }
}

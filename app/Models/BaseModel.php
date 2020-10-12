<?php

namespace App\Models;

use App\Builders\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class BaseModel
 * @package App\Models
 * @method  \App\Builders\QueryBuilder defaultDatatable(\Illuminate\Http\Request $request)
 * @method  \App\Builders\QueryBuilder datatable(array $options = [])
 */
class BaseModel extends Model
{
    use SoftDeletes;

    public function newEloquentBuilder($query)
    {
        return new QueryBuilder($query);
    }

    public function previous()
    {
        return $this->find($this->id - 1);
    }

    public function next()
    {
        return $this->find($this->id + 1);
    }
}

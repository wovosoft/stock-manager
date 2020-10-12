<?php

namespace App\Models;

use App\Traits\HistoryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyProductRecord extends BaseModel
{
    protected $guarded = ['id'];
    use HasFactory, HistoryTrait;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

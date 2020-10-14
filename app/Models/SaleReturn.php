<?php

namespace App\Models;

use App\Traits\HistoryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class SaleReturn extends BaseModel
{
    use HasFactory, HistoryTrait;

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function saleItem()
    {
        return $this->belongsTo(SaleItem::class, 'sale_item_id');
    }
}

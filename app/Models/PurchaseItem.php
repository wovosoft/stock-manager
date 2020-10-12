<?php

namespace App\Models;


use App\Traits\HistoryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseItem extends BaseModel
{
    use HistoryTrait;
    use HasFactory;

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id', 'supplier_id');
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id', 'id');
    }
}

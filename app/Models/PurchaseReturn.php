<?php

namespace App\Models;

use App\Traits\HistoryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseReturn extends BaseModel
{
    use HasFactory, HistoryTrait;

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

    public function purchaseItem()
    {
        return $this->belongsTo(PurchaseItem::class, 'purchase_item_id');
    }
}

<?php

namespace App\Models;


use App\Traits\HistoryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends BaseModel
{
    use HasFactory, HistoryTrait;

    public function items()
    {
        return $this->hasMany(SaleItem::class, 'sale_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(SalePayment::class, 'sale_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, "customer_id", "id");
    }
}

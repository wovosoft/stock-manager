<?php

namespace App\Models;

use App\Traits\HistoryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckOutItem extends Model
{
    use HistoryTrait;
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($item) {
            $product = Product::query()->findOrFail($item->product_id);
            $product->decrement('quantity', $item->quantity);
        });
        static::updating(function ($item) {
            $product = Product::query()->findOrFail($item->product_id);
            $product->quantity = $product->quantity + $item->getOriginal('quantity') - $item->quantity;
            $product->saveOrFail();
        });
        static::deleting(function ($item) {
            $product = Product::query()->findOrFail($item->product_id);
            $product->increment('quantity', $item->quantity);
        });
    }

    public function checkOut()
    {
        return $this->belongsTo(CheckOut::class, 'check_out_id', 'id');
    }
}

<?php

namespace App\Models;


use App\Traits\HistoryTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class SaleItem extends BaseModel
{
    use HasFactory, HistoryTrait;

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::creating(function (self $item) {
            $item->applytCalculatedValues();
            if ($item->sale->status === 'Processed') {
                DB::transaction(function () use ($item) {
                    $item->product->decrement('quantity', $item->quantity);
                });
            }
        });
        static::updating(function (self $item) {
            $item->applytCalculatedValues();
            DB::transaction(function () use ($item) {
                if ($item->getOriginal('quantity') !== $item->quantity) {
                    $item->product->increment('quantity', $item->getOriginal('quantity') - $item->quantity);
                }
                if ($item->returned_quantity <= $item->quantity) {
                    if ($item->returned_quantity !== $item->getOriginal('returned_quantity')) {
                        $item->product->increment('quantity', $item->returned_quantity - $item->getOriginal('returned_quantity'));
                        $returning = new SaleReturn();
                        $returning->forceFill([
                            "sale_id" => $item->sale_id,
                            "sale_item_id" => $item->id,
                            "product_id" => $item->product_id,
                            "customer_id" => $item->customer_id,
                            "quantity" => $item->returned_quantity - $item->getOriginal('returned_quantity'),
                            "amount" => round(($item->returned_quantity - $item->getOriginal('returned_quantity')) * $item->price, 2)
                        ]);
                        $returning->saveOrFail();
                    }
                }
            });
        });
        static::updated(function (self $item) {
            $sale = $item->sale;
            $sale->returned = $sale->items->sum('returned_total');
            $sale->saveOrFail();
        });
        static::deleting(function (self $item) {
            $item->product->increment('quantity', $item->quantity);
            $sale = $item->sale;
            $sale->returned = $sale->items->sum('returned_total');
            $sale->saveOrFail();
        });
    }

    private function applytCalculatedValues()
    {
        $this->total = round(($this->quantity ?? 0) * ($this->price ?? 0), 2);
        $this->returned_total = round(($this->returned_quantity ?? 0) * ($this->price ?? 0), 2);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id', 'customer_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function unit()
    {
        /**
         * Tutorial:
         * First we need to get the product. So, using
         * products.id (first key, means target model Product) = sale_items.product_id (Local Key means Sale Items local key)
         * now we got product,
         * so now
         */
        return $this->hasOneThrough(
            Unit::class,
            Product::class,
            'id',
            'id',
            'product_id',
            'unit_id',
        );
    }
}

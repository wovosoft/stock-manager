<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\SalePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class SaleItemController extends Controller
{
    public static function routes()
    {
        Route::post('sales/{sale}/items/store', [self::class, 'store'])->name('SaleItems.Store');
        Route::post('sales/{sale}/items/{sale_item}/delete', [self::class, 'delete'])->name('SaleItems.Delete');

//        Route::post("sales/items/return/{sale}/{sale_item}", [static::class, 'returnItem'])->name('Sales.Items.Return');
    }

    public function store(Sale $sale, Request $request)
    {
        try {
            $request->validate([
                "items" => ["required", "array", "min:1"]
            ]);
            DB::beginTransaction();
            foreach ($request->post('items') as $s_item) {
                SaleItem::query()
                    ->findOrNew(isset($s_item['id']) ? $s_item['id'] : null)
                    ->forceFill([
                        "sale_id" => $sale->id,
                        "product_id" => $s_item['product_id'],
                        "customer_id" => $sale->customer_id,
                        "quantity" => $s_item['quantity'],
                        "price" => round($s_item['price'], 2),
                        "total" => round($s_item['total'], 2)
                    ])
                    ->saveOrFail();
            }
            $customer = Customer::query()->findOrFail($sale->customer_id);
            $current_balance = $customer->current_balance;

            $total = $sale->items()->sum('total');
            $sale->total = $total;
            $sale->payable = $total;
            $sale->previous_balance = round($current_balance, 2);
            $sale->current_balance = round($current_balance + $total - $sale->paid ?? 0, 2);
            $sale->is_modified = true;
            $sale->saveOrFail();
            DB::commit();
            return successResponse();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function delete(Sale $sale, SaleItem $saleItem, Request $request)
    {
        try {
            $saleItem->delete();
            $total = $sale->items()->sum('total');
            $sale->total = $total;
            $sale->payable = $total;
            $sale->saveOrFail();

            return successResponse();
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

//    public function returnItem(Sale $sale, SaleItem $saleItem, Request $request)
//    {
//        try {
//            $request->validate([
//                'returning' => 'required'
//            ]);
//            if (($request->post('returning') <= 0) || ($saleItem->quantity - $saleItem->returned_quantity < $request->post('returning'))) {
//                throw new \Exception("Invalid Returning Quantity");
//            }
//            DB::beginTransaction();
//            if ($request->post('returning')) {
//                $saleItem->returned_quantity += $request->post('returning');
//                $saleItem->saveOrFail();
//            }
//            DB::commit();
//            return successResponse();
//        } catch (\Throwable $exception) {
//            DB::rollBack();
//            throw $exception;
//        }
//    }
}

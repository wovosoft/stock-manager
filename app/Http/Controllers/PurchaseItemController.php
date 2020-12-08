<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class PurchaseItemController extends Controller
{
    public static function routes()
    {
        Route::post('purchases/{purchase}/items/store', [self::class, 'store'])->name('PurchaseItems.Store');
        Route::post('purchases/{purchase}/items/{purchase_item}/delete', [self::class, 'delete'])->name('PurchaseItems.Delete');
//        Route::post("purchases/items/return/{purchase}/{purchase_item}", [static::class, 'returnItem'])->name('Purchases.Items.Return');
    }

    public function store(Purchase $purchase, Request $request)
    {
        try {
            $request->validate([
                "items" => ["required", "array", "min:1"]
            ]);
            DB::beginTransaction();
            foreach ($request->post('items') as $s_item) {
                PurchaseItem::query()
                    ->findOrNew(isset($s_item['id']) ? $s_item['id'] : null)
                    ->forceFill([
                        "purchase_id" => $purchase->id,
                        "product_id" => $s_item['product_id'],
                        "supplier_id" => $purchase->supplier_id,
                        "quantity" => $s_item['quantity'],
                        "price" => round($s_item['price'], 2),
                        "total" => round($s_item['total'], 2)
                    ])
                    ->saveOrFail();
            }
            $supplier = Supplier::query()->findOrFail($purchase->supplier_id);
            $current_balance = $supplier->current_balance;

            $total = $purchase->items()->sum('total');
            $purchase->total = $total;
            $purchase->payable = $total;
            $purchase->previous_balance = round($current_balance, 2);
            $purchase->current_balance = round($current_balance + $total - $purchase->paid ?? 0, 2);
            $purchase->is_modified = true;
            $purchase->saveOrFail();
            DB::commit();
            return successResponse();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function delete(Purchase $purchase, PurchaseItem $purchaseItem, Request $request)
    {
        try {
            $purchaseItem->delete();
            $total = $purchase->items()->sum('total');
            $purchase->total = $total;
            $purchase->payable = $total;
            $purchase->saveOrFail();

            return successResponse();
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

//    public function returnItem(Purchase $purchase, PurchaseItem $purchaseItem, Request $request)
//    {
//        try {
//            $request->validate([
//                'returning' => 'required'
//            ]);
//            if (($request->post('returning') <= 0) || ($purchaseItem->quantity - $purchaseItem->returned_quantity < $request->post('returning'))) {
//                throw new \Exception("Invalid Returning Quantity");
//            }
//            DB::beginTransaction();
//            if ($request->post('returning')) {
//                $purchaseItem->returned_quantity += $request->post('returning');
//                $purchaseItem->saveOrFail();
//            }
//            DB::commit();
//            return successResponse();
//        } catch (\Throwable $exception) {
//            DB::rollBack();
//            throw $exception;
//        }
//    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class PurchaseItemController extends Controller
{
    public static function routes()
    {
        Route::post("purchases/items/return/{purchase}/{purchase_item}", [static::class, 'returnItem'])->name('Purchases.Items.Return');
    }

    public function returnItem(Purchase $purchase, PurchaseItem $purchaseItem, Request $request)
    {
        try {
            $request->validate([
                'returning' => 'required'
            ]);
            if (($request->post('returning') <= 0) || ($purchaseItem->quantity - $purchaseItem->returned_quantity < $request->post('returning'))) {
                throw new \Exception("Invalid Returning Quantity");
            }
            DB::beginTransaction();
            if ($request->post('returning')) {
                $purchaseItem->returned_quantity += $request->post('returning');
                $purchaseItem->saveOrFail();
            }
            DB::commit();
            return successResponse();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}

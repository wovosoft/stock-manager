<?php

namespace App\Http\Controllers;

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
        Route::post("sales/items/change_status", [static::class, 'changeStatus'])->name('Sales.Items.Change.Status');
        Route::post("sales/items/return/{sale}/{sale_item}", [static::class, 'returnItem'])->name('Sales.Items.Return');
    }

    public function changeStatus(Request $request)
    {
        try {
            $request->validate([
                "id" => "required",
                "type" => "required",
                "sale_id" => "required",
                "status" => "required"
            ]);
            DB::beginTransaction();
            if (in_array($request->post("type"), ["status", "restocked", "refunded"])) {
                $item = SaleItem::query()->findOrFail($request->post("sale_id"));
                if ($request->post("type") == "status") {
                    $item->status = $request->post("status");
                } elseif ($request->post('type') == 'restocked') {
                    $item->restocked = $request->post("status");
                    //false to true
                    if (!$item->getOriginal('restocked') && $item->restocked) {
                        $product = Product::query()->findOrFail($item->product_id);
                        $product->increment('quantity', $item->quantity);
                    } //true to false
                    elseif ($item->getOriginal('restocked') && !$item->restocked) {
                        $product = Product::query()->findOrFail($item->product_id);
                        $product->decrement('quantity', $item->quantity);
                    }
                } elseif ($request->post('type') == 'refunded') {
                    $item->refunded = $request->post("status");
                    $sale = $item->sale;
                    if ($sale->paid >= $item->payable) {
                        $sale_payment = new SalePayment();
                        $sale_payment->sale_id = $sale->id;
                        $sale_payment->customer_id = $sale->customer_id;
                        $sale_payment->payment_method = "Cash";
                        $sale_payment->payment_amount = -$item->payable;
                        $sale_payment->saveOrFail();
                    }
                }

                $item->saveOrFail();

            }

            DB::commit();
            return successResponse();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function returnItem(Sale $sale, SaleItem $saleItem, Request $request)
    {
        try {
            $request->validate([
                'return_quantity' => 'required'
            ]);
            DB::beginTransaction();
            $saleItem->return_quantity = $request->post('return_quantity');
            $saleItem->saveOrFail();
            DB::commit();
            return successResponse();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}

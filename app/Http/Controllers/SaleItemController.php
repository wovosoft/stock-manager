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
        Route::post("sales/items/return/{sale}/{sale_item}", [static::class, 'returnItem'])->name('Sales.Items.Return');
    }


    public function returnItem(Sale $sale, SaleItem $saleItem, Request $request)
    {
        try {
            $request->validate([
                'returning' => 'required'
            ]);
            if (($request->post('returning') <= 0) || ($saleItem->quantity - $saleItem->returned_quantity < $request->post('returning'))) {
                throw new \Exception("Invalid Returning Quantity");
            }
            DB::beginTransaction();
            if ($request->post('returning')) {
                $saleItem->returned_quantity += $request->post('returning');
                $saleItem->saveOrFail();
            }
            DB::commit();
            return successResponse();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}

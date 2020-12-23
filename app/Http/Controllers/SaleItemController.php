<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleItem;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class SaleItemController extends Controller
{
    public static function routes()
    {
        Route::post('sales/{sale}/items/store', [self::class, 'store'])->name('SaleItems.Store');
        Route::post('sales/{sale}/items/{sale_item}/delete', [self::class, 'delete'])->name('SaleItems.Delete');
        Route::match(['get', 'post'], 'sale_items/export/{type?}', [self::class, 'exportItems'])->name('SaleItems.Export');

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

    public function exportItems(string $type = 'html', Request $request)
    {
        try {
            $request->validate([
                "starting_date" => ["required", "date"],
                "ending_date" => ["nullable", "date"]
            ]);

            $items = SaleItem::query()
                ->leftJoin("products", "products.id", "=", "sale_items.product_id")
                ->groupBy('sale_items.product_id')
//                ->orderBy("products.code")
                ->select([
                    //doesn't support in current namecheap mysql version
//                    'products.id',
//                    "products.name",
//                    "products.code",
                    DB::raw("sale_items.product_id as id"),
                    'name' => function (Builder $builder) {
                        $builder
                            ->from('products')
                            ->where('products.id', '=', DB::raw('sale_items.product_id'))
                            ->selectRaw('products.name');
                    },
                    DB::raw("SUM(sale_items.quantity) as quantity"),
                ]);
            //both starting and ending dates are available, cause starting date is required
            if ($request->has('ending_date')) {
                $items
                    ->whereBetween("sale_items.created_at", [
                        Carbon::parse($request->input("starting_date"))->toDateString(),
                        Carbon::parse($request->input("ending_date"))->toDateString()
                    ]);
            } else {
                $items
                    ->whereDate("sale_items.created_at", "=", Carbon::parse($request->input("starting_date"))->toDateString());
            }
            if ($type == 'pdf') {
                return \PDF::loadView("pages.sales.products_summery", [
                    "items" => $items->get(),
                    "starting_date" => $request->post("starting_date"),
                    "ending_date" => $request->post("ending_date") ?? null,
                    "html" => false
                ])->stream('product_wise_sales.pdf');
            }
            return view("pages.sales.products_summery", [
                "items" => $items->get(),
                "starting_date" => $request->post("starting_date"),
                "ending_date" => $request->post("ending_date") ?? null,
                "html" => true
            ]);
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

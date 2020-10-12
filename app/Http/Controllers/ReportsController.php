<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class ReportsController extends Controller
{
    protected string $date;

    public static function routes()
    {
        Route::match(['get', 'post'], 'reports/products/daily/{date}', [static::class, 'dailyProducts'])->name("Reports.Products.Daily");
        Route::post('reports/customers/sales/daily/{date}', [static::class, 'dailyCustomerSalesReport'])->name("Reports.Customers.Sales.Daily");
    }


    public function dailyProducts(string $date, Request $request)
    {
        try {
            $this->date = $date;
            if (!Storage::exists('product_records/' . Carbon::parse($date)->format('Y_m_d') . ".json")) {
                Artisan::call("record:products");
            }
            return $this
                ->paginate($this->getRecord($date), $request->post('per_page') ?? 30)
                ->setPath(\request()->url());
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    private function getRecord(string $date)
    {
        if (!Storage::exists('product_records/' . Carbon::parse($date)->format('Y_m_d') . ".json")) {
            return [];
        }
        return json_decode(Storage::get('product_records/' . Carbon::parse($date)->format('Y_m_d') . ".json"));
    }

    private function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $collection = new LengthAwarePaginator(
            array_slice($items, max(0, ($page - 1) * $perPage), $perPage),
            count($items),
            $perPage,
            $page,
            $options
        );
        $products = Product::query()
            ->whereIn('id', $collection->getCollection()->pluck('id'))
            ->select(['id', 'name', 'code', 'unit_id'])
            ->with(['unit:id,name'])
            ->get()
            ->keyBy('id');


        $sale_items = SaleItem::query()
            ->whereIn('product_id', $collection->getCollection()->pluck('id'))
            ->whereDate("created_at", "=", $this->date)
            ->groupBy('product_id')
            ->select([
                "product_id",
                DB::raw("SUM(quantity) as sales_quantity"),
                DB::raw("SUM(payable) as sales_payable"),
            ])
            ->get()
            ->keyBy('product_id');

        $yesterday_data = Collection::make(
            $this->getRecord(Carbon::parse($this->date)->addDays(-1)->format('Y-m-d'))
        )->keyBy('id');


        $collection->getCollection()->transform(function ($item) use ($yesterday_data, $sale_items, $products) {
            $the_item = $products->get($item->id);
            $sale_item = $sale_items->get($item->id);
            $previous_data = $yesterday_data->get($item->id);
            $item->name = $the_item->name;
            $item->code = $the_item->code;
            $item->unit = $the_item->unit;
            $item->sales_quantity = $sale_item ? $sale_item->sales_quantity : 0;
            $item->sales_payable = $sale_item ? $sale_item->sales_payable : 0;
            $item->previous_quantity = $previous_data ? $previous_data->quantity : null;
            return $item;
        });
        return $collection;
    }

    public function dailyCustomerSalesReport(string $date, Request $request)
    {
        try {
            $items = Sale::query()
                ->leftJoin("customers", "customers.id", "=", "sales.customer_id")
                ->whereDate("sales.created_at", "=", $date)
                ->groupBy("sales.customer_id")
                ->select([
                    "sales.customer_id",
                    "customers.name",
                    DB::raw("sum(sales.payable) as sales_amount"),
                    DB::raw("sum(sales.paid) as paid_amount"),
                    DB::raw("sum(sales.balance) as balance_amount"),
                ])
                ->orderBy("sales.customer_id", "asc")
                ->paginate($request->post('per_page') ?? 30);
            return $items;
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}

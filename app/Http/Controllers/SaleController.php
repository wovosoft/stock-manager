<?php

namespace App\Http\Controllers;

use App\Builders\Reports;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\SalePayment;
use App\Traits\Crud;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class SaleController extends Controller
{
    protected string $model = Sale::class;
    public array $search_selects = ['id',];
    public array $search_fields = ['id',];
    use Crud;

    public static function routes()
    {
        Route::post("sales/store", '\\' . __CLASS__ . '@store')->name('Sales.Store');
        Route::post("sales/list", '\\' . __CLASS__ . '@list')->name('Sales.List');
        Route::post("sales/delete", '\\' . __CLASS__ . '@delete')->name('Sales.Delete');
        Route::post("sales/due-sales/{customer}", '\\' . __CLASS__ . '@dueSales')->name('Sales.Due');
        Route::post("sales/reports", '\\' . __CLASS__ . '@reports')->name('Sales.Reports');
        Route::get("sales/invoice/pdf/{sale}/{type?}", '\\' . __CLASS__ . '@invoicePdf')->name('Sales.Invoice.PDF');
    }

    /**
     * @param $items
     * @param int $sale_tax
     * @param int $sale_discount
     * @return int[]
     */
    private function getSalesAndItemsPayable($items = [], $tax = 0, $discount = 0)
    {
        $items_total = 0;     //sale Total
        if (is_array($items) && count($items)) {
            foreach ($items as $sitem) {
                $items_total += ($sitem['quantity'] ?? 0) * ($sitem['price'] ?? 0);
            }
        }
        return [
            $items_total,
            $items_total * (1 + ($tax ?? 0) / 100 - ($discount ?? 0) / 100)
        ];
    }

    private function applySalePayment(Sale $sale, Request $request)
    {
        if ($request->post('payment_amount')) {
            try {
                DB::beginTransaction();
                $customer = Customer::query()->findOrFail($sale->customer_id);
                $customer->addPayment(
                    round($request->post('payment_amount'), 2),
                    $request->post('payment_method'),
                    $request->post("bank"),
                    $request->post("check"),
                    $request->post("transaction_no")
                );
                DB::commit();
            } catch (\Throwable $exception) {
                DB::rollBack();
                throw $exception;
            }
        }
    }

    private function applySaleItems(Sale $sale, Request $request)
    {
        try {
            foreach ($request->post('items') as $si) {
                DB::beginTransaction();
                $sale_item = new SaleItem();
                $sale_item->sale_id = $sale->id;
                $sale_item->product_id = $si['product_id'];
                $sale_item->customer_id = $sale->customer_id;
                $sale_item->quantity = $si['quantity'];
                $sale_item->price = round($si['price'], 2);
                $sale_item->saveOrFail();
                DB::commit();
            }
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                "customer_id" => "required",
                "items" => "required",
            ]);
            DB::beginTransaction();

            $sale = Sale::query()->findOrNew($request->post('id'));
            $sale->customer_id = $request->post("customer_id");
            $sale->tax = $request->post('tax') ?? 0;
            $sale->discount = $request->post('discount') ?? 0;
            $sale->date = $request->post('date') ?? Carbon::now()->format('Y-m-d');
            $sale->status = $request->post('status') ?? "Processed";
            $sale->note = $request->post('note') ?? null;
            $sale->paid = round($request->post('payment_amount'), 2);

            /**
             * Now we calculate the total and payable
             */
            [$items_total, $sale_payable] = $this->getSalesAndItemsPayable(
                $request->post("items"),
                $request->post('tax') ?? 0,
                $request->post('discount') ?? 0
            );
            $sale->total = round($items_total, 2);
            $sale->payable = round($sale_payable, 2);
            $sale->saveOrFail();

            $this->applySalePayment($sale, $request);
            $this->applySaleItems($sale, $request);

            DB::commit();
            return successResponse([
                "sale_id" => $sale->id
            ]);
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function list(Request $request)
    {
        try {
            $items = Sale::query()
                ->leftJoin("customers", "customers.id", "=", "sales.customer_id")
                ->select(["sales.*", "customers.name as customer_name"])
                ->with([
                    'items' => function ($query) {
                        $query->leftJoin("products", "products.id", "=", "sale_items.product_id");
                        $query->select(["sale_items.*", DB::raw("CONCAT(products.id,' # ',products.name) as product_name")]);
                    },
                    'customer'
                ]);

            if ($request->has('id')) {
                return $items->findOrFail($request->post('id'));
            }

            return response()
                ->json($items->defaultDatatable($request, "sales.created_at"))
                ->header("overview", json_encode(
                    resetQueryForOverview($items)
                        ->distinct()
                        ->select([
                            DB::raw("SUM(sales.payable) as sales_payable"),
                            DB::raw("COUNT(sales.id) as sales_quantity"),
                        ])
                        ->first()
                ));
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * This method returns only the due sales.
     * @param $customer_id
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     * @throws \Throwable
     */
    public function dueSales($customer_id, Request $request)
    {
        try {
            $items = Sale::query()
                ->leftJoin("customers", "customers.id", "=", "sales.customer_id")
                ->select([
                    "sales.id",
                    "customers.name as customer_name",
                    "sales.payable",
                    "sales.paid",
                    "sales.balance",
                ])
                ->where("sales.customer_id", "=", $customer_id)
                ->where("sales.balance", ">", 0);

            if ($request->has('id')) {
                return $items->findOrFail($request->post('id'));
            }
            return $items->get();
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function reports(Request $request)
    {
        try {
            $request->validate([
                "type" => "required"
            ]);
            if ($request->post("type") == "overview") {
                return response()->json(
                    (new Reports())->salesOverview([
                        "starting_date" => $request->post("starting_date"),
                        "ending_date" => $request->post("ending_date"),
                    ])->first()
                );
            } elseif ($request->post("type") == "list_sales") {
                return response()->json(
                    (new Reports())->listSales([
                        "starting_date" => $request->post("starting_date"),
                        "ending_date" => $request->post("ending_date"),
                    ])->get()
                );
            } elseif ($request->post("type") == "list_sale_items") {
                return response()->json(
                    (new Reports())->listSaleItems([
                        "starting_date" => $request->post("starting_date"),
                        "ending_date" => $request->post("ending_date"),
                    ])->get()
                );
            } elseif ($request->post("type") == "products") {
                return response()->json(
                    (new Reports())->listSaleProducts([
                        "starting_date" => $request->post("starting_date"),
                        "ending_date" => $request->post("ending_date"),
                    ])->get()
                );
            } elseif ($request->post("type") == "customer") {
                return response()->json(
                    (new Reports())->listSaleByCustomer([
                        "starting_date" => $request->post("starting_date"),
                        "ending_date" => $request->post("ending_date"),
                    ])->get()
                );
            }
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function invoicePdf($sale_id, $type = "html")
    {
        $sale = Sale::query()
            ->with([
                'items',
                'customer'
            ])
            ->findOrFail($sale_id);


        if ($type == "html") {
            return view("pages.sales.invoice", [
                "sale" => $sale,
            ]);
        }

        return \PDF::loadView('pages.sales.invoice', [
            "sale" => $sale,
        ])->stream("invoice-$sale_id.pdf");
    }
}

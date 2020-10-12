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
        $items_payable = 0;     //sale Total
        if (is_array($items) && count($items)) {
            foreach ($items as $sitem) {
                $items_payable += (($sitem['quantity'] ?? 0) * ($sitem['price'] ?? 0)) * (1 + ($sitem['tax'] ?? 0) / 100 - ($sitem['discount'] ?? 0) / 100);
            }
        }
        $sale_payable = $items_payable * (1 + ($tax ?? 0) / 100 - ($discount ?? 0) / 100);
        return [
            $items_payable,
            $sale_payable
        ];
    }

    private function applySalePayment(Sale $sale, Request $request)
    {
        if ($request->post('payment_amount')) {
            $sale_payment = new SalePayment();
            $sale_payment->sale_id = $sale->id;
            $sale_payment->customer_id = $sale->customer_id;
            $sale_payment->payment_amount = round($request->post('payment_amount'), 2);
            $sale_payment->payment_method = $request->post('payment_method');
            $sale_payment->bank = $request->post("bank");
            $sale_payment->check = $request->post("check");
            $sale_payment->transaction_no = $request->post("transaction_no");
            return $sale_payment->saveOrFail();
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
                $sale_item->tax = isset($si['tax']) ? $si['tax'] : 0;
                $sale_item->discount = isset($si['discount']) ? $si['discount'] : 0;
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


            /**
             * Now we calculate the total and payable
             */
            [$items_payable, $sale_payable] = $this->getSalesAndItemsPayable(
                $request->post("items"),
                $request->post('tax') ?? 0,
                $request->post('discount') ?? 0
            );
            $sale->total = round($items_payable, 2);
            $sale->payable = round($sale_payable, 2);
            $sale->saveOrFail();

            $this->applySalePayment($sale, $request);
            $this->applySaleItems($sale, $request);

            DB::commit();
            return response()->json([
                "status" => true,
                "title" => 'SUCCESS!',
                "type" => "success",
                "msg" => ' Successfully Done',
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
                ->header("overview", json_encode(resetQueryForOverview($items)->select([
                    DB::raw("SUM(payable) as sales_payable"),
                    DB::raw("SUM(paid) as sales_paid"),
                    DB::raw("(SUM(payable) - SUM(paid)) as sales_balance"),
                ])->first()));
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
//                'payments',
                'customer'
            ])
            ->findOrFail($sale_id);

        $previous_balance = Sale::query()
            ->where('customer_id', '=', $sale->customer_id)
            ->where('id', '<', $sale->id)
            ->select([
                DB::raw("SUM(payable) as total_payable"),
                DB::raw("SUM(paid) as total_paid"),
                DB::raw("(SUM(payable)-SUM(paid)) as calculated_balance"),
                DB::raw("SUM(balance) as total_balance"),
            ])->first();

        if ($type == "html") {
            return view("pages.invoice", [
                "sale" => $sale,
                "previous_balance" => $previous_balance
            ]);
        }

        return \PDF::loadView('pages.invoice', [
            "sale" => $sale,
            "previous_balance" => $previous_balance
        ])->stream("invoice-$sale_id.pdf");
    }
}

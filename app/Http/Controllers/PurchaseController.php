<?php

namespace App\Http\Controllers;

use App\Builders\Reports;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\PurchasePayment;
use App\Models\Supplier;
use App\Traits\Crud;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class PurchaseController extends Controller
{
    protected string $model = Purchase::class;
    public array $search_selects = ['id',];
    public array $search_fields = ['id',];
    use Crud;

    public static function routes()
    {
        Route::name('Purchases.')->prefix('purchases')->group(function () {
            Route::post("store", [self::class, 'store'])->name('Store');
            Route::post("list", [self::class, 'list'])->name('List');
            Route::post("delete", [self::class, 'delete'])->name('Delete');
            Route::post("due-purchases/{supplier}", [self::class, 'duePurchases'])->name('Due');
            Route::get("invoice/pdf/{purchase}/{type?}", [self::class, 'invoicePdf'])->name('Invoice.PDF');
        });
    }

    /**
     * @param array $items
     * @param int $tax
     * @param int $discount
     * @return int[]
     */
    private function getPurchasesAndItemsPayable($items = [], $tax = 0, $discount = 0)
    {
        $items_total = 0;     //sale Total
        if (is_array($items) && count($items)) {
            foreach ($items as $sitem) {
                $items_total += ($sitem['quantity'] ?? 0) * ($sitem['cost'] ?? 0);
            }
        }
        return [
            $items_total,
            $items_total * (1 + ($tax ?? 0) / 100 - ($discount ?? 0) / 100)
        ];
    }

    /**
     * @param Purchase $purchase
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    private function applyPayment(Purchase $purchase, Request $request)
    {
        if ($request->has('payment_amount') && (float)$request->post('payment_amount')) {
            try {
                DB::beginTransaction();
                $supplier = Supplier::query()->findOrFail($purchase->supplier_id);
                $supplier->addPayment(
                    round($request->post('payment_amount'), 2),
                    $request->post('payment_method'),
                    $request->post("bank"),
                    $request->post("check"),
                    $request->post("transaction_no"),
                    Carbon::now()->add(CarbonInterval::milliseconds(500))->toDateTimeString()
                );
                DB::commit();
                return successResponse();
            } catch (\Throwable $exception) {
                DB::rollBack();
                throw $exception;
            }
        }
    }

    private function applyItems(Purchase $purchase, Request $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->post('items') as $si) {
                $purchase_item = new PurchaseItem();
                $purchase_item->forceFill([
                    "purchase_id" => $purchase->id,
                    "product_id" => $si['product_id'],
                    "supplier_id" => $purchase->supplier_id,
                    "quantity" => $si['quantity'],
                    "price" => round($si['cost'], 2)
                ]);
                $purchase_item->saveOrFail();
            }
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                "supplier_id" => "required",
                "items" => "required",
            ]);
            /**
             * Now we calculate the total and payable
             */
            [$items_total, $purchase_payable] = $this->getPurchasesAndItemsPayable(
                $request->post("items"),
                $request->post('tax') ?? 0,
                $request->post('discount') ?? 0
            );

            $supplier = Supplier::query()->findOrFail($request->post("supplier_id"));
            $previous_balance = $supplier->current_balance;
            $current_balance = $previous_balance + $purchase_payable - $request->post('payment_amount') ?? 0;

            DB::beginTransaction();
            $purchase = Purchase::query()->findOrNew($request->post('id'));
            $purchase->forceFill([
                "supplier_id" => $request->post("supplier_id"),
                "tax" => $request->post('tax') ?? 0,
                "discount" => $request->post('discount') ?? 0,
                "date" => $request->post('date') ?? Carbon::now()->format('Y-m-d'),
                "status" => $request->post('status') ?? "Processed",
                "note" => $request->post('note') ?? null,
                "total" => round($items_total, 2),
                "payable" => round($purchase_payable, 2),
                "paid" => round($request->post('payment_amount'), 2),
                "previous_balance" => round($previous_balance, 2),
                "current_balance" => $current_balance
            ]);
            $purchase->saveOrFail();

            $this->applyPayment($purchase, $request);
            $this->applyItems($purchase, $request);

            DB::commit();
            return successResponse([
                "purchase_id" => $purchase->id
            ]);
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function list(Request $request)
    {
        try {
            $items = Purchase::query()
                ->leftJoin("suppliers", "suppliers.id", "=", "purchases.supplier_id")
                ->select(["purchases.*", "suppliers.name as supplier_name"])
                ->with([
                    'items' => function ($query) {
                        $query->leftJoin("products", "products.id", "=", "purchase_items.product_id");
                        $query->select(["purchase_items.*", DB::raw("CONCAT(products.id,' # ',products.name) as product_name")]);
                    },
                    'supplier'
                ]);

            if ($request->has('id')) {
                return $items->findOrFail($request->post('id'));
            }

            return response()
                ->json($items->defaultDatatable($request, "purchases.created_at"))
                ->header("overview", json_encode(
                    resetQueryForOverview($items)
                        ->whereNull('purchases.deleted_at')
                        ->select([
                            DB::raw("SUM(purchases.payable) as purchases_payable"),
                            DB::raw("SUM(purchases.returned) as purchases_returned"),
                            DB::raw("COUNT(purchases.id) as purchases_quantity"),
                        ])
                        ->first()
                ));
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * This method returns only the due sales.
     * @param $supplier_id
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     * @throws \Throwable
     */
    public function dueSales($supplier_id, Request $request)
    {
        try {
            $items = Purchase::query()
                ->leftJoin("suppliers", "suppliers.id", "=", "purchases.supplier_id")
                ->select([
                    "purchases.id",
                    "suppliers.name as supplier_name",
                    "purchases.payable",
                    "purchases.paid",
                    "purchases.balance",
                ])
                ->where("purchases.supplier_id", "=", $supplier_id)
                ->where("purchases.balance", ">", 0);

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

    public function invoicePdf($purchase_id, $type = "html")
    {
        $purchase = Purchase::query()
            ->with([
                'items',
                'supplier'
            ])
            ->findOrFail($purchase_id);


        if ($type == "html") {
            return view("pages.purchases.invoice", [
                "purchase" => $purchase,
            ]);
        }

        return \PDF::loadView('pages.purchases.invoice', [
            "purchase" => $purchase,
        ])->stream("invoice-$purchase_id.pdf");
    }
}

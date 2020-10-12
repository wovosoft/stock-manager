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
        Route::post("purchases/store", '\\' . __CLASS__ . '@store')->name('Purchases.Store');
        Route::post("purchases/list", '\\' . __CLASS__ . '@list')->name('Purchases.List');
        Route::post("purchases/delete", '\\' . __CLASS__ . '@delete')->name('Purchases.Delete');
        Route::post("purchases/due-purchases/{supplier}", '\\' . __CLASS__ . '@duePurchases')->name('Purchases.Due');
    }

    public function store(Request $request)
    {
        try {
            /**
             * Supplier is searched first so that process fails, if supplier not found.
             */
            $supplier = Supplier::query()->findOrFail($request->post("supplier_id"));

            /**
             * Now we calculate the total and payable
             */
            $items_payable = 0;     //purchase Total
            if ($request->has('items') && is_array($request->post("items"))) {
                foreach ($request->post("items") as $sitem) {
                    $items_payable += ($sitem['quantity'] * $sitem['price']) * (1 + $sitem['tax'] / 100 - $sitem['discount'] / 100);
                }
            }
            $purchase_payable = $items_payable * (1 + ($request->post('tax') ?? 0) / 100 - ($request->post('discount') ?? 0) / 100);

            $item = Purchase::query()->findOrNew($request->post('id'));
            $item->supplier_id = $request->post('supplier_id');
            $item->tax = $request->post('tax') ?? 0;
            $item->discount = $request->post('discount') ?? 0;
            $item->date = $request->post('date') ?? Carbon::now()->format('Y-m-d');
            $item->status = $request->post('status') ?? "Processed";
            $item->note = $request->post('note') ?? null;
            $item->total = round($items_payable, 2);
            $item->payable = round($purchase_payable, 2);
            $item->saveOrFail();

            $purchase_payment = new PurchasePayment();
            $purchase_payment->purchase_id = $item->id;
            $purchase_payment->supplier_id = $item->supplier_id;
            $purchase_payment->payment_amount = round($request->post('payment_amount'), 2);
            $purchase_payment->payment_method = $request->post('payment_method');
            $purchase_payment->bank = $request->post("bank");
            $purchase_payment->check = $request->post("check");
            $purchase_payment->transaction_no = $request->post("transaction_no");
            $purchase_payment->saveOrFail();

            foreach ($request->post('items') as $si) {
                $product = Product::query()->findOrFail($si['product_id']);
                $product->increment('quantity', $si['quantity']);

                $purchase_item = new PurchaseItem();
                $purchase_item->purchase_id = $item->id;
                $purchase_item->product_id = $si['product_id'];
                $purchase_item->supplier_id = $item->supplier_id;
                $purchase_item->quantity = $si['quantity'];
                $purchase_item->price = round($si['price'], 2);
                $purchase_item->total = round($si['quantity'] * $si['price'], 2);
                $purchase_item->tax = isset($si['tax']) ? $si['tax'] : 0;
                $purchase_item->discount = isset($si['discount']) ? $si['discount'] : 0;
                $purchase_item->payable = round($purchase_item->total * (1 - $purchase_item->discount / 100 + $purchase_item->tax / 100), 2);
                $purchase_item->status = "Processed";
                $purchase_item->saveOrFail();

            }
            if (!$item) {
                throw new \Exception("Unable to Save the Data", 304);
            }

            return response()->json([
                "status" => true,
                "title" => 'SUCCESS!',
                "type" => "success",
                "msg" => ' Successfully Done'
            ]);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function list(Request $request)
    {
        try {
//            $paid = "(SELECT IFNULL(SUM(purchase_payments.payment_amount),0) FROM purchase_payments WHERE purchase_payments.purchase_id = purchases.id)";
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
                ->json($items->defaultDatatable($request))
                ->header("overview", (new Reports())->toJson()->purchasesOverview())
                ->header("payable", $items->sum("payable"))
                ->header("paid", $items->sum("paid"));
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * This method returns only the due purchases.
     * @param $supplier_id
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     * @throws \Throwable
     */
    public function duepurchases($supplier_id, Request $request)
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
}

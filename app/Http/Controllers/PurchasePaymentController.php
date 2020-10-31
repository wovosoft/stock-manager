<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchasePayment;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class PurchasePaymentController extends Controller
{
    public static function routes()
    {
        Route::name('Payments.')->prefix('payments/purchases')->group(function () {
            Route::post("take/{purchase}", [self::class, 'store'])->name('Purchases.Store');
            Route::post("list", [self::class, 'purchasePayments'])->name('Purchases.List');
            Route::match(['get', 'post'], "{purchasePayment}/invoice/{pdf?}", [static::class, 'purchasePaymentInvoice'])->name('Purchases.Invoice');
        });

    }

    public function store(Purchase $purchase, Request $request)
    {
        try {
            $request->validate([
                "supplier_id" => "required",
                "payment_amount" => "required",
                "payment_method" => "required",
            ]);

            DB::beginTransaction();
            $payment = new PurchasePayment();
            $payment->forceFill([
//                "purchase_id" => $purchase->id,
                "supplier_id" => $purchase->supplier_id,
                "payment_method" => $request->post("payment_method") ?? 0,
                "payment_amount" => round($request->post("payment_amount") ?? 0, 2),
                "bank" => $request->post("bank") ?? 0,
                "check" => $request->post("check") ?? 0,
                "transaction_no" => $request->post("transaction_no") ?? 0,
            ]);
            $payment->saveOrFail();
            DB::commit();
            return successResponse();

        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function purchasePayments(Request $request)
    {
        try {
            $items = PurchasePayment::query()
                ->select([
                    'purchase_payments.id',
                    'purchase_payments.supplier_id',
                    DB::raw("CONCAT(suppliers.id,' # ',suppliers.name) as supplier"),
                    'purchase_payments.payment_method',
                    'purchase_payments.payment_amount',
                    'purchase_payments.bank',
                    'purchase_payments.check',
                    'purchase_payments.transaction_no',
                    "users.name as given_by",
                    'purchase_payments.created_at',
                ])
                ->leftJoin("suppliers", "suppliers.id", "=", "purchase_payments.supplier_id")
                ->leftJoin("users", "users.id", "=", "purchase_payments.given_by");
            if ($request->post("date")) {
                $items->whereDate("purchase_payments.created_at", "=", $request->post("date"));
            }
            return $items->defaultDatatable($request);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function purchasePaymentInvoice($purchasePayment, string $pdf = 'pdf', Request $request)
    {
        try {
            $payment = PurchasePayment::query()
                ->select([
                    "purchase_payments.*",
                    "payable" => function (Builder $builder) {
                        $builder
                            ->from('purchase_items')
                            ->where('purchase_items.supplier_id', '=', DB::raw('purchase_payments.supplier_id'))
                            ->where("purchase_items.created_at", '<', DB::raw('purchase_payments.created_at'))
                            ->whereNull("purchase_items.deleted_at")
                            ->selectRaw("IFNULL(SUM(purchase_items.total),0)");
                    },
                    "paid" => function (Builder $builder) {
                        $builder
                            ->from(DB::raw('purchase_payments as prev_purchase_payments'))
                            ->where('prev_purchase_payments.supplier_id', '=', DB::raw('purchase_payments.supplier_id'))
                            ->where("prev_purchase_payments.created_at", '<', DB::raw('purchase_payments.created_at'))
                            ->whereNull("prev_purchase_payments.deleted_at")
                            ->selectRaw("IFNULL(SUM(prev_purchase_payments.payment_amount),0)");
                    },
                    "returned" => function (Builder $builder) {
                        $builder
                            ->from('purchase_returns')
                            ->where('purchase_returns.supplier_id', '=', DB::raw('purchase_payments.supplier_id'))
                            ->whereNull("purchase_returns.deleted_at")
                            ->where("purchase_returns.created_at", '<', DB::raw('purchase_payments.created_at'))
                            ->selectRaw("IFNULL(SUM(purchase_returns.amount),0)");
                    },
                    "previous_balance" => function (Builder $builder) {
                        $builder->selectRaw("SUM(payable - paid - returned)");
                    }
                ])
                ->with(["supplier"])
                ->findOrFail($purchasePayment);
            if ($pdf == 'pdf') {
                return app('PDF')::loadView("pages.suppliers.payment_invoice", [
                    "payment" => $payment,
                    "pdf" => $pdf == 'pdf'
                ])->stream("payment_invoice_$purchasePayment.pdf");
            }
            return view("pages.suppliers.payment_invoice", [
                "payment" => $payment,
                "pdf" => $pdf == 'pdf'
            ]);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}

<?php

namespace App\Http\Controllers;


use App\Models\Sale;
use App\Models\SalePayment;
use App\Traits\Crud;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class SalePaymentController extends Controller
{
    public string $model = SalePayment::class;
    use Crud;

    public static function routes()
    {
        Route::name("Payments.")->prefix("payments/sales")->group(function () {
            Route::post("{sale}/take", [static::class, 'store'])->name('Sales.Store');
            Route::post("list", [static::class, 'salePayments'])->name('Sales.List');
            Route::match(['get', 'post'], "{salePayment}/invoice/{pdf?}", [static::class, 'salePaymentInvoice'])->name('Sales.Invoice');
            Route::post("delete", [static::class, 'delete'])->name('Sales.Delete');
        });
    }

    public function store(Sale $sale, Request $request)
    {
        try {
            $request->validate([
                "payment_amount" => "required",
                "payment_method" => "required",
            ]);

            DB::beginTransaction();
            $payment = new SalePayment();
            $payment->forceFill([
                "customer_id" => $sale->customer_id,
                "payment_method" => $request->post("payment_method") ?? 'Cash',
                "payment_amount" => round($request->post("payment_amount") ?? 0, 2),
                "bank" => $request->post("bank") ?? 0,
                "check" => $request->post("check") ?? 0,
                "transaction_no" => $request->post("transaction_no"),
            ]);
            $payment->saveOrFail();

            DB::commit();
            return successResponse();

        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function salePayments(Request $request)
    {
        try {
            $items = SalePayment::query()
                ->select([
                    'sale_payments.id',
                    'sale_payments.customer_id',
                    DB::raw("customers.name as customer"),
                    'sale_payments.payment_method',
                    'sale_payments.payment_amount',
                    'sale_payments.bank',
                    'sale_payments.check',
                    'sale_payments.transaction_no',
                    "users.name as taken_by",
                    'sale_payments.created_at',
                ])
                ->leftJoin("customers", "customers.id", "=", "sale_payments.customer_id")
                ->leftJoin("users", "users.id", "=", "sale_payments.taken_by");
            if ($request->post("date")) {
                $items->whereDate("sale_payments.created_at", "=", $request->post("date"));
            }
            return $items->defaultDatatable($request);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function salePaymentInvoice($salePayment, string $pdf = 'pdf', Request $request)
    {
        try {
            $payment = SalePayment::query()
                ->select([
                    "sale_payments.*",
                    "payable" => function (Builder $builder) {
                        $builder
                            ->from('sale_items')
                            ->where('sale_items.customer_id', '=', DB::raw('sale_payments.customer_id'))
                            ->where("sale_items.created_at", '<', DB::raw('sale_payments.created_at'))
                            ->whereNull("sale_items.deleted_at")
                            ->selectRaw("IFNULL(SUM(sale_items.total),0)");
                    },
                    "paid" => function (Builder $builder) {
                        $builder
                            ->from(DB::raw('sale_payments as prev_sale_payments'))
                            ->where('prev_sale_payments.customer_id', '=', DB::raw('sale_payments.customer_id'))
                            ->where("prev_sale_payments.created_at", '<', DB::raw('sale_payments.created_at'))
                            ->whereNull("prev_sale_payments.deleted_at")
                            ->selectRaw("IFNULL(SUM(prev_sale_payments.payment_amount),0)");
                    },
                    "returned" => function (Builder $builder) {
                        $builder
                            ->from('sale_returns')
                            ->where('sale_returns.customer_id', '=', DB::raw('sale_payments.customer_id'))
                            ->whereNull("sale_returns.deleted_at")
                            ->where("sale_returns.created_at", '<', DB::raw('sale_payments.created_at'))
                            ->selectRaw("IFNULL(SUM(sale_returns.amount),0)");
                    },
                    "previous_balance" => function (Builder $builder) {
                        $builder->selectRaw("SUM(payable - paid - returned)");
                    }
                ])
                ->with(["customer"])
                ->findOrFail($salePayment);
            if ($pdf == 'pdf') {
                return app('PDF')::loadView("pages.customers.payment_invoice", [
                    "payment" => $payment,
                    "pdf" => $pdf == 'pdf'
                ])->stream("payment_invoice_$salePayment.pdf");
            }
            return view("pages.customers.payment_invoice", [
                "payment" => $payment,
                "pdf" => $pdf == 'pdf'
            ]);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}

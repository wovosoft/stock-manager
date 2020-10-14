<?php

namespace App\Http\Controllers;

use App\Models\CustomerFund;
use App\Models\Sale;
use App\Models\SalePayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class SalePaymentController extends Controller
{
    public static function routes()
    {
        Route::post("payments/sales/take/{sale}", [static::class, 'store'])->name('Payments.Sales.Store');
        Route::post("payments/sales/{sale}/list", [static::class, 'salePayments'])->name('Payments.Single.Sales.Payments');
    }

    public function store(Sale $sale, Request $request)
    {
        try {
            $request->validate([
                "payment_amount" => "required",
                "payment_method" => "required",
            ]);
            if (!$sale) {
                throw new \Exception("The Sale not Found", 404);
            }
//            if ($request->post("payment_amount") > $sale->payable) {
//                throw new \Exception("Payment Amount Should not be greater than Payable Amount");
//            }
            DB::beginTransaction();
            $payment = new SalePayment();
            $payment->customer_id = $sale->customer_id;
            $payment->payment_method = $request->post("payment_method") ?? 'Cash';
            $payment->payment_amount = round($request->post("payment_amount") ?? 0, 2);
            $payment->bank = $request->post("bank") ?? 0;
            $payment->check = $request->post("check") ?? 0;
            $payment->transaction_no = $request->post("transaction_no");
            $payment->saveOrFail();

            DB::commit();
            return successResponse();

        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function salePayments(Sale $sale, Request $request)
    {
        try {
            $items = $sale->payments()
                ->select([
                    'sale_payments.id',
                    'sale_payments.sale_id',
                    'sale_payments.customer_id',
                    DB::raw("CONCAT(customers.id,' # ',customers.name) as customer"),
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
            return $items->latest()->get();
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchasePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class PurchasePaymentController extends Controller
{
    public static function routes()
    {
        Route::post("payments/purchases/take/{purchase}", '\\' . __CLASS__ . '@store')->name('Payments.Purchases.Store');
        Route::post("payments/purchases/{purchase}/list", '\\' . __CLASS__ . '@purchasePayments')->name('Payments.Single.Purchases.Payments');
    }

    public function store(Purchase $purchase, Request $request)
    {
        try {
            $request->validate([
                "payment_amount" => "required",
                "payment_method" => "required",
            ]);
            if (!$purchase) {
                throw new \Exception("The Purchase not Found", 404);
            }
//            if ($request->post("payment_amount") > $sale->payable) {
//                throw new \Exception("Payment Amount Should not be greater than Payable Amount");
//            }
            $payment = new PurchasePayment();
            $payment->purchase_id = $purchase->id;
            $payment->supplier_id = $purchase->supplier_id;
            $payment->payment_method = $request->post("payment_method") ?? 0;
            $payment->payment_amount = round($request->post("payment_amount") ?? 0, 2);
            $payment->bank = $request->post("bank") ?? 0;
            $payment->check = $request->post("check") ?? 0;
            $payment->transaction_no = $request->post("transaction_no") ?? 0;
            $payment->saveOrFail();


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

    public function purchasePayments(Purchase $purchase, Request $request)
    {
        try {
            return $purchase->payments()
                ->select([
                    'purchase_payments.id',
                    'purchase_payments.purchase_id',
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
                ->leftJoin("users", "users.id", "=", "purchase_payments.given_by")
                ->latest()->get();
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}

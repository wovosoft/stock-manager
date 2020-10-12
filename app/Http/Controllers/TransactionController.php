<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\SalePayment;
use App\Traits\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class TransactionController extends Controller
{
    public static function routes()
    {
        Route::post("transactions/list/in", '\\' . __CLASS__ . '@listIn')->name('Transactions.List.In');
        Route::post("transactions/list/out", '\\' . __CLASS__ . '@listOut')->name('Transactions.List.Out');
        Route::post("transactions/search", '\\' . __CLASS__ . '@search')->name('Transactions.Search');
        Route::post("transactions/store", '\\' . __CLASS__ . '@store')->name('Transactions.Store');
        Route::post("transactions/delete", '\\' . __CLASS__ . '@delete')->name('Transactions.Delete');
        Route::post("transactions/transactionByCustomer", [static::class, 'transactionByCustomer'])->name('Transactions.By.Customers');
        Route::post("transactions/setTransactionByCustomer", [static::class, 'setTransactionByCustomer'])->name('Transactions.Set.By.Customers');
        Route::post("transactions/transactionCollectionByCustomer", [static::class, 'transactionCollectionByCustomer'])->name('Transactions.Collections.By.Customers');
    }

    public function store(Request $request)
    {
        try {
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

    public function listIn(Request $request)
    {
        try {
            $request->validate([
                "date" => ["required"]
            ]);

            $items = SalePayment::query()
                ->leftJoin("customers", "customers.id", "=", "sale_payments.customer_id")
                ->whereDate('sale_payments.created_at', '=', $request->post("date"))
                ->select([
                    "sale_payments.id",
                    DB::raw("CONCAT(customers.id,' # ',customers.name) as customer"),
                    DB::raw("sale_payments.payment_amount as amount"),
                    DB::raw("sale_payments.created_at as date"),
                ]);

            return $items->paginate($request->post("per_page") ?? 30);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function listOut(Request $request)
    {
        try {

        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function transactionByCustomer(Request $request)
    {
        try {
            $request->validate([
                "date" => ["required"]
            ]);
            $items = Customer::query()
                ->leftJoin("sales", function ($query) {
                    $query->on('sales.customer_id', '=', 'customers.id');
                })
                ->whereNull("sales.deleted_at")
                ->select([
                    "customers.*",
                    DB::raw("sum(sales.payable) as total_payable"),
                    DB::raw("sum(sales.paid) as total_paid"),
                    DB::raw("sum(sales.balance) as total_balance"),
                ])
                ->having("total_balance", ">", "0")
                ->with("sales", function ($query) {
                    $query->where('sales.balance', '>', 0)
                        ->whereNull('sales.deleted_at')
                        ->select(["id", "customer_id", "payable", "paid", "balance", "created_at"]);
                })
                ->groupBy("customers.id");
            return $items->paginate($request->post('per_page') ?? 30);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function setTransactionByCustomer(Request $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->post('sales') as $sale) {
                if (isset($sale['amount']) && $sale['amount'] > 0) {
                    $payment = new SalePayment();
                    $payment->sale_id = $sale['id'];
                    $payment->customer_id = $sale['customer_id'];
                    $payment->payment_method = $request->post("payment_method") ?? 'Cash';
                    $payment->payment_amount = round($sale['amount'] ?? 0, 2);
                    $payment->bank = $request->post("bank") ?? 0;
                    $payment->check = $request->post("check") ?? 0;
                    $payment->transaction_no = $request->post("transaction_no");
                    $payment->saveOrFail();
                }
            }
            DB::commit();
            return successResponse();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function transactionCollectionByCustomer(Request $request)
    {
        try {
            $request->validate([
                "date" => ["required"]
            ]);
            $items = Customer::query()
                ->leftJoin("sale_payments", function ($query) {
                    $query->on('sale_payments.customer_id', '=', 'customers.id');
                })
                ->whereNull("sale_payments.deleted_at")
                ->whereDate("sale_payments.created_at", "=", $request->post("date"))
                ->select([
                    "customers.id",
                    "customers.name",
                    DB::raw("sum(sale_payments.payment_amount) as total_amount"),
                ])
                ->groupBy("customers.id");
            return $items->paginate($request->post('per_page') ?? 30);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}

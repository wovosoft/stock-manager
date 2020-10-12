<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CustomerBalanceController extends Controller
{
    public static function routes()
    {
        Route::post("balance-sheet/customers/single", '\\' . __CLASS__ . '@singleBalance')->name('Balance.Customers.Single');
    }

    public function singleBalance(Request $request)
    {
        try {
            $request->validate([
                "customer_id" => "required"
            ]);
            $funds_deposit = "(SELECT IFNULL(SUM(customer_funds.payment_amount),0) FROM customer_funds WHERE customer_funds.type='deposit' AND customer_id=customers.id)";
            $funds_withdrawn = "(SELECT IFNULL(SUM(customer_funds.payment_amount),0) FROM customer_funds WHERE customer_funds.type='withdrawn' AND customer_id=customers.id)";
            $sales_payable = "(SELECT IFNULL(SUM(sales.payable),0) FROM sales WHERE sales.customer_id = customers.id)";
            $sales_paid = "(SELECT IFNULL(SUM(sales.paid),0) FROM sales WHERE sales.customer_id = customers.id)";
            $sales_balance = "(SELECT IFNULL(SUM(sales.balance),0) FROM sales WHERE sales.customer_id = customers.id)";

            return Customer::query()
                ->select([
                    "customers.id",
                    "customers.name",
                ])
                ->selectRaw("$funds_deposit  as deposit_amount")
                ->selectRaw("$funds_withdrawn  as withdrawn_amount")
                ->selectRaw("(($funds_deposit) - ($funds_withdrawn)) as funds_balance")
                ->selectRaw("$sales_payable  as sales_payable")
                ->selectRaw("$sales_paid  as sales_paid")
                ->selectRaw("$sales_balance  as sales_balance")
                ->selectRaw("(($funds_deposit) - ($sales_balance) - ($funds_withdrawn))  as final_balance")
                ->findOrFail($request->post("customer_id"));
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SupplierBalanceController extends Controller
{
    public static function routes()
    {
        Route::post("balance-sheet/suppliers/single", '\\' . __CLASS__ . '@singleBalance')->name('Balance.Suppliers.Single');
    }

    public function singleBalance(Request $request)
    {
        try {
            $request->validate([
                "supplier_id" => "required"
            ]);
            $funds_deposit = "(SELECT IFNULL(SUM(supplier_funds.payment_amount),0) FROM supplier_funds WHERE supplier_funds.type='deposit' AND supplier_id=suppliers.id)";
            $funds_withdrawn = "(SELECT IFNULL(SUM(supplier_funds.payment_amount),0) FROM supplier_funds WHERE supplier_funds.type='withdrawn' AND supplier_id=suppliers.id)";
            $sales_payable = "(SELECT IFNULL(SUM(sales.payable),0) FROM sales WHERE sales.supplier_id = suppliers.id)";
            $sales_paid = "(SELECT IFNULL(SUM(sales.paid),0) FROM sales WHERE sales.supplier_id = suppliers.id)";
            $sales_balance = "(SELECT IFNULL(SUM(sales.balance),0) FROM sales WHERE sales.supplier_id = suppliers.id)";


            return Supplier::query()
                ->select([
                    "suppliers.id",
                    "suppliers.name",
                    "suppliers.phone",
                ])
                ->selectRaw("$funds_deposit  as deposit_amount")
                ->selectRaw("$funds_withdrawn  as withdrawn_amount")
                ->selectRaw("(($funds_deposit) - ($funds_withdrawn)) as funds_balance")
//                ->selectRaw("$sales_payable  as sales_payable")
//                ->selectRaw("$sales_paid  as sales_paid")
//                ->selectRaw("$sales_balance  as sales_balance")
//                ->selectRaw("(($funds_deposit) - ($sales_balance) - ($funds_withdrawn))  as final_balance");
                ->findOrFail($request->post("supplier_id"));
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}

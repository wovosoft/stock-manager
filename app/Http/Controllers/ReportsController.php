<?php

namespace App\Http\Controllers;

use App\Models\CapitalDeposit;
use App\Models\CapitalWithdraw;
use App\Models\Customer;
use App\Models\EmployeeSalary;
use App\Models\Expense;
use App\Models\Product;
use App\Models\PurchasePayment;
use App\Models\PurchaseReturn;
use App\Models\SalePayment;
use App\Models\SaleReturn;
use App\Models\Supplier;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ReportsController extends Controller
{
    protected string $date;

    public static function routes()
    {
        Route::name("Reports.")->prefix("reports")->group(function () {
            Route::match(['get', 'post'], 'products/daily/{date}/{export?}', [self::class, 'dailyProducts'])->name("Products.Daily");
            Route::match(['get', 'post'], 'customers/sales/{pdf?}', [self::class, 'customerSalesReport'])->name("Customers.Sales");
            Route::match(['get', 'post'], 'suppliers/purchases/{pdf?}', [self::class, 'supplierPurchasesReport'])->name("Suppliers.Purchases");
            Route::match(['get', 'post'], 'income_expenses/{date}/{pdf?}', [self::class, 'incomeExpense'])->name("IncomeExpense");
            Route::match(['get', 'post'], 'financial_report/{pdf?}', [self::class, 'financialReport'])->name("ShortFinancialReport");
        });
    }

    private function dailyProductsReport(string $date, ?string $export = null, Request $request)
    {
        try {
            return Product::query()
                ->select([
                    "id",
                    "name",
                    "code",
                    "prev_purchased_items" => function (Builder $builder) use ($date) {
                        $builder
                            ->from("purchase_items")
                            ->whereNull('purchase_items.deleted_at')
                            ->whereDate("purchase_items.created_at", "<", $date)
                            ->where("purchase_items.product_id", "=", DB::raw("products.id"))
                            ->selectRaw("IFNULL(SUM(purchase_items.quantity),0)");
                    },
                    "prev_purchase_returned_items" => function (Builder $builder) use ($date) {
                        $builder
                            ->from("purchase_returns")
                            ->whereNull('purchase_returns.deleted_at')
                            ->whereDate("purchase_returns.created_at", "<", $date)
                            ->where("purchase_returns.product_id", "=", DB::raw("products.id"))
                            ->selectRaw("IFNULL(SUM(purchase_returns.quantity),0)");
                    },
                    "prev_sold_items" => function (Builder $builder) use ($date) {
                        $builder
                            ->from("sale_items")
                            ->whereNull('sale_items.deleted_at')
                            ->whereDate("sale_items.created_at", "<", $date)
                            ->where("sale_items.product_id", "=", DB::raw("products.id"))
                            ->selectRaw("IFNULL(SUM(sale_items.quantity),0)");
                    },
                    "prev_sold_returned_items" => function (Builder $builder) use ($date) {
                        $builder
                            ->from("sale_returns")
                            ->whereNull('sale_returns.deleted_at')
                            ->whereDate("sale_returns.created_at", "<", $date)
                            ->where("sale_returns.product_id", "=", DB::raw("products.id"))
                            ->selectRaw("IFNULL(SUM(sale_returns.quantity),0)");
                    },
                    "purchased_items" => function (Builder $builder) use ($date) {
                        $builder
                            ->from("purchase_items")
                            ->whereNull('purchase_items.deleted_at')
                            ->whereDate("purchase_items.created_at", "=", $date)
                            ->where("purchase_items.product_id", "=", DB::raw("products.id"))
                            ->selectRaw("IFNULL(SUM(purchase_items.quantity),0)");
                    },
                    "purchase_returned_items" => function (Builder $builder) use ($date) {
                        $builder
                            ->from("purchase_returns")
                            ->whereNull('purchase_returns.deleted_at')
                            ->whereDate("purchase_returns.created_at", "=", $date)
                            ->where("purchase_returns.product_id", "=", DB::raw("products.id"))
                            ->selectRaw("IFNULL(SUM(purchase_returns.quantity),0)");
                    },
                    "sold_items" => function (Builder $builder) use ($date) {
                        $builder
                            ->from("sale_items")
                            ->whereNull('sale_items.deleted_at')
                            ->whereDate("sale_items.created_at", "=", $date)
                            ->where("sale_items.product_id", "=", DB::raw("products.id"))
                            ->selectRaw("IFNULL(SUM(sale_items.quantity),0)");
                    },
                    "sold_returned_items" => function (Builder $builder) use ($date) {
                        $builder
                            ->from("sale_returns")
                            ->whereNull('sale_returns.deleted_at')
                            ->whereDate("sale_returns.created_at", "=", $date)
                            ->where("sale_returns.product_id", "=", DB::raw("products.id"))
                            ->selectRaw("IFNULL(SUM(sale_returns.quantity),0)");
                    }
                ]);

        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function dailyProducts(string $date, ?string $export = null, Request $request)
    {
        try {
            if ($export == "pdf") {
                return \PDF::loadView("pages.products.daily_product_stock", [
                    "items" => $this->dailyProductsReport($date, $export, $request)->get(),
                    "date" => $date
                ])->stream("product_stock_report-{$date}.pdf");
            }
            return $this
                ->dailyProductsReport($date, $export, $request)
                ->paginate($request->post('per_page') ?? 30);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }


    private function setDateRanges(Builder $builder, $date = "created_at", $start_date = null, $end_date = null)
    {
        if ($start_date) {
            $builder->whereDate($date, ">=", $start_date);
        }
        if ($end_date) {
            $builder->whereDate($date, "<=", $end_date);
        }
    }

    private function getCustomerSalesReport(Request $request)
    {
        return Customer::query()
            ->select([
                "customers.id",
                "customers.name",
                "customers.phone",
                "payable" => function (Builder $builder) use ($request) {
                    $builder
                        ->from("sales")
                        ->select(DB::raw("IFNULL(SUM(sales.payable),0)"))
                        ->whereNull('sales.deleted_at')
                        ->where("sales.customer_id", "=", DB::raw("customers.id"));
                    $this->setDateRanges(
                        $builder,
                        "sales.created_at",
                        $request->get('start_date') ?? null,
                        $request->get('end_date') ?? null
                    );
                },
                "paid" => function (Builder $builder) use ($request) {
                    $builder
                        ->from("sale_payments")
                        ->select(DB::raw("IFNULL(SUM(sale_payments.payment_amount),0)"))
                        ->whereNull("sale_payments.deleted_at")
                        ->where("sale_payments.customer_id", "=", DB::raw("customers.id"));
                    $this->setDateRanges(
                        $builder,
                        "sale_payments.created_at",
                        $request->get('start_date') ?? null,
                        $request->get('end_date') ?? null
                    );
                },
                "returned" => function (Builder $builder) use ($request) {
                    $builder
                        ->from("sale_returns")
                        ->select(DB::raw("IFNULL(SUM(sale_returns.amount),0)"))
                        ->whereNull("sale_returns.deleted_at")
                        ->where("sale_returns.customer_id", "=", DB::raw("customers.id"));
                    $this->setDateRanges(
                        $builder,
                        "sale_returns.created_at",
                        $request->get('start_date') ?? null,
                        $request->get('end_date') ?? null
                    );
                },
                "balance" => function ($builder) {
                    $builder->select([
                        DB::raw("payable - paid - returned")
                    ]);
                }
            ])
            ->having('payable', '!=', 0)
            ->orHaving('paid', '!=', 0)
            ->orHaving('returned', '!=', 0)
            ->orHaving('balance', '!=', 0);
    }

    public function customerSalesReport(?string $pdf = null, Request $request)
    {
//        return $this->getCustomerSalesReport($request)->toSql();
        try {
            if ($pdf == 'pdf') {
                $request->validate([
                    "start_date" => "required",
                    "end_date" => "required",
                ]);
                return \PDF::loadView("pages.customers.sales_report", [
                    "items" => $this->getCustomerSalesReport($request)->get(),
                    "start_date" => Carbon::parse($request->get('start_date')),
                    "end_date" => Carbon::parse($request->get('end_date'))
                ])->stream("customer_sales_report.pdf");
            }
            return $this->getCustomerSalesReport($request)
                ->paginate($request->post('per_page') ?? 15);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    private function getSupplierPurchasesReport(Request $request)
    {
        return Supplier::query()
            ->select([
                "suppliers.id",
                "suppliers.name",
                "suppliers.phone",
                "payable" => function (Builder $builder) use ($request) {
                    $builder
                        ->from("purchases")
                        ->select(DB::raw("IFNULL(SUM(purchases.payable),0)"))
                        ->whereNull('purchases.deleted_at')
                        ->where("purchases.supplier_id", "=", DB::raw("suppliers.id"));
                    $this->setDateRanges(
                        $builder,
                        "purchases.created_at",
                        $request->get('start_date') ?? null,
                        $request->get('end_date') ?? null
                    );
                },
                "paid" => function (Builder $builder) use ($request) {
                    $builder
                        ->from("purchase_payments")
                        ->select(DB::raw("IFNULL(SUM(purchase_payments.payment_amount),0)"))
                        ->whereNull("purchase_payments.deleted_at")
                        ->where("purchase_payments.supplier_id", "=", DB::raw("suppliers.id"));
                    $this->setDateRanges(
                        $builder,
                        "purchase_payments.created_at",
                        $request->get('start_date') ?? null,
                        $request->get('end_date') ?? null
                    );
                },
                "returned" => function (Builder $builder) use ($request) {
                    $builder
                        ->from("purchase_returns")
                        ->select(DB::raw("IFNULL(SUM(purchase_returns.amount),0)"))
                        ->whereNull("purchase_returns.deleted_at")
                        ->where("purchase_returns.supplier_id", "=", DB::raw("suppliers.id"));
                    $this->setDateRanges(
                        $builder,
                        "purchase_returns.created_at",
                        $request->get('start_date') ?? null,
                        $request->get('end_date') ?? null
                    );
                },
                "balance" => function ($builder) {
                    $builder->select([
                        DB::raw("payable - paid - returned")
                    ]);
                }
            ]);
    }

    public function supplierPurchasesReport(?string $pdf = null, Request $request)
    {
        try {
            if ($pdf == 'pdf') {
                $request->validate([
                    "start_date" => "required",
                    "end_date" => "required",
                ]);
                return \PDF::loadView("pages.suppliers.purchases_report", [
                    "items" => $this->getSupplierPurchasesReport($request)->get(),
                    "start_date" => Carbon::parse($request->get('start_date')),
                    "end_date" => Carbon::parse($request->get('end_date'))
                ])->stream("supplier_purchases_report.pdf");
            }
            return $this->getSupplierPurchasesReport($request)
                ->paginate($request->post('per_page') ?? 15);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    private function getIncomeExpenseReport(string $date, Request $request)
    {
        try {
            $expenses = Expense::query()
                ->leftJoin("expense_categories", "expense_categories.id", "=", "expenses.expense_category_id")
                ->select([
                    DB::raw("'expense' as title"),
                    DB::raw('expense_categories.name as description'),
                    DB::raw("expenses.amount as expense"),
                    DB::raw("0 as income"),
                    DB::raw("expenses.created_at as date")
                ])
                ->whereNull('expenses.deleted_at')
                ->whereDate("expenses.created_at", "=", $date);

            $purchase_payments = PurchasePayment::query()
                ->leftJoin("suppliers", 'suppliers.id', '=', 'purchase_payments.supplier_id')
                ->select([
                    DB::raw("'purchase_payment' as title"),
                    DB::raw('suppliers.name as description'),
                    DB::raw("purchase_payments.payment_amount as expense"),
                    DB::raw("0 as income"),
                    DB::raw("purchase_payments.created_at as date")
                ])
                ->whereNull('purchase_payments.deleted_at')
                ->whereDate("purchase_payments.created_at", "=", $date);

            $purchase_returns = PurchaseReturn::query()
                ->leftJoin("suppliers", 'suppliers.id', '=', 'purchase_returns.supplier_id')
                ->select([
                    DB::raw("'purchase_return' as title"),
                    DB::raw('suppliers.name as description'),
                    DB::raw("0 as expense"),
                    DB::raw("purchase_returns.amount as income"),
                    DB::raw("purchase_returns.created_at as date")
                ])
                ->whereNull('purchase_returns.deleted_at')
                ->whereDate("purchase_returns.created_at", "=", $date);

            $employee_salaries = EmployeeSalary::query()
                ->leftJoin("employees", 'employees.id', '=', 'employee_salaries.employee_id')
                ->select([
                    DB::raw("'employee_salary' as title"),
                    DB::raw('employees.name as description'),
                    DB::raw("employee_salaries.payment_amount as expense"),
                    DB::raw("0 as income"),
                    DB::raw("employee_salaries.created_at as date")
                ])
                ->whereNull('employee_salaries.deleted_at')
                ->whereDate("employee_salaries.created_at", "=", $date);


            $sale_returns = SaleReturn::query()
                ->leftJoin("customers", 'customers.id', '=', 'sale_returns.customer_id')
                ->select([
                    DB::raw("'sale_return' as title"),
                    DB::raw('customers.name as description'),
                    DB::raw("sale_returns.amount as expense"),
                    DB::raw("0 as income"),
                    DB::raw("sale_returns.created_at as date")
                ])
                ->whereNull('sale_returns.deleted_at')
                ->whereDate("sale_returns.created_at", "=", $date);

            $capital_deposits = CapitalDeposit::query()
                ->select([
                    DB::raw("'capital_deposit' as title"),
                    DB::raw('reference as description'),
                    DB::raw("0 as expense"),
                    DB::raw("payment_amount as income"),
                    DB::raw("created_at as date")
                ])
                ->whereNull('capital_deposits.deleted_at')
                ->whereDate("created_at", "=", $date);

            $capital_withdraws = CapitalWithdraw::query()
                ->select([
                    DB::raw("'capital_withdraw' as title"),
                    DB::raw("reference as description"),
                    DB::raw("payment_amount as expense"),
                    DB::raw("0 as income"),
                    DB::raw("created_at as date")
                ])
                ->whereNull('capital_withdraws.deleted_at')
                ->whereDate("created_at", "=", $date);

            return SalePayment::query()
                ->leftJoin("customers", 'customers.id', '=', 'sale_payments.customer_id')
                ->select([
                    DB::raw("'sale_payment' as title"),
                    DB::raw('customers.name as description'),
                    DB::raw("0 as expense"),
                    DB::raw("sale_payments.payment_amount as income"),
                    DB::raw("sale_payments.created_at as date")
                ])
                ->whereNull('sale_payments.deleted_at')
                ->whereDate("sale_payments.created_at", "=", $date)
                ->union($expenses)
                ->union($purchase_payments)
                ->union($purchase_returns)
                ->union($sale_returns)
                ->union($employee_salaries)
                ->union($capital_deposits)
                ->union($capital_withdraws)
                ->orderBy("date");
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    //this is not debit/credit , its only economical transaction.
    public function incomeExpense(string $date, ?string $pdf = null, Request $request)
    {
        try {
            $yesterday_items = $this->getIncomeExpenseReport(Carbon::parse($date)->addDays(-1)->format('Y-m-d'), $request)->get();
            $previous_balance = $yesterday_items->sum('income') - $yesterday_items->sum('expense');
            if ($pdf == 'pdf') {
                return \PDF::loadView("pages.collection.income_expense_report", [
                    "items" => $this->getIncomeExpenseReport($date, $request)->get(),
                    "date" => Carbon::parse($date),
                    "previous_balance" => $previous_balance,
                    "html" => false
                ])->stream("supplier_purchases_report.pdf");
            } elseif ($pdf == 'html') {
                return view("pages.collection.income_expense_report", [
                    "items" => $this->getIncomeExpenseReport($date, $request)->get(),
                    "date" => Carbon::parse($date),
                    "previous_balance" => $previous_balance,
                    "html" => true
                ]);
            }
            return $this->getIncomeExpenseReport($date, $request)
                ->paginate($request->post('per_page') ?? 30);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    private function setDateRange(Builder $builder, Request $request)
    {
        if ($request->input('start_date')) {
            $builder->whereDate("created_at", ">=", $request->input('start_date'));
        }
        if ($request->input('end_date')) {
            $builder->whereDate("created_at", "<=", $request->input('end_date'));
        }
        return $builder;
    }

    public function financialReport(?string $pdf = null, Request $request)
    {
        try {
            $item = User::query()
                ->select([
                    "capital_deposit" => function (Builder $builder) use ($request) {
                        $builder
                            ->from('capital_deposits')
                            ->whereNull('capital_deposits.deleted_at')
                            ->selectRaw("IFNULL(SUM(capital_deposits.payment_amount),0)");
                        $this->setDateRanges($builder, $request);
                    },
                    "capital_withdraw" => function (Builder $builder) use ($request) {
                        $builder
                            ->from('capital_withdraws')
                            ->whereNull('capital_withdraws.deleted_at')
                            ->selectRaw("IFNULL(SUM(capital_withdraws.payment_amount),0)");
                        $this->setDateRanges($builder, $request);
                    },
                    "capital_balance" => function (Builder $builder) use ($request) {
                        $builder->selectRaw("capital_deposit - capital_withdraw");
                    },
                    "purchase_payment" => function (Builder $builder) use ($request) {
                        $builder->from("purchase_payments")
                            ->whereNull('purchase_payments.deleted_at')
                            ->selectRaw("IFNULL(SUM(purchase_payments.payment_amount),0)");
                        $this->setDateRanges($builder, $request);
                    },
                    "purchase_return" => function (Builder $builder) use ($request) {
                        $builder->from("purchase_returns")
                            ->whereNull('purchase_returns.deleted_at')
                            ->selectRaw("IFNULL(SUM(purchase_returns.amount),0)");
                        $this->setDateRanges($builder, $request);
                    },
                    "purchase_balance" => function (Builder $builder) {
                        $builder->selectRaw("purchase_payment - purchase_return");
                    },
                    "sale_payment" => function (Builder $builder) use ($request) {
                        $builder->from("sale_payments")
                            ->whereNull('sale_payments.deleted_at')
                            ->selectRaw("IFNULL(SUM(sale_payments.payment_amount),0)");
                        $this->setDateRanges($builder, $request);
                    },
                    "sale_return" => function (Builder $builder) use ($request) {
                        $builder->from("sale_returns")
                            ->whereNull('sale_returns.deleted_at')
                            ->selectRaw("IFNULL(SUM(sale_returns.amount),0)");
                        $this->setDateRanges($builder, $request);
                    },
                    "sale_balance" => function (Builder $builder) {
                        $builder->selectRaw("sale_payment - sale_return");
                    },
                    "expense" => function (Builder $builder) use ($request) {
                        $builder->from("expenses")
                            ->whereNull('expenses.deleted_at')
                            ->selectRaw("IFNULL(SUM(expenses.amount),0)");
                        $this->setDateRanges($builder, $request);
                    },
                    "employee_salary" => function (Builder $builder) use ($request) {
                        $builder->from("employee_salaries")
                            ->whereNull('employee_salaries.deleted_at')
                            ->selectRaw("IFNULL(SUM(employee_salaries.payment_amount),0)");
                        $this->setDateRanges($builder, $request);
                    },
                    "balance" => function (Builder $builder) {
                        $builder->selectRaw("capital_deposit - capital_withdraw - purchase_payment + purchase_return + sale_payment -  sale_return - expense - employee_salary ");
                    }
                ])
                ->first();
            if ($pdf == "pdf") {
                return \PDF::loadView("pages.financial.short", [
                    "item" => $item,
                    "html" => false
                ])->stream('full_financial_report.pdf');
            } elseif ($pdf == 'html') {
                return view("pages.financial.short", [
                    "item" => $item,
                    "html" => true
                ]);
            }
            return $item;
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}
/*
 * //            $this->date = $date;
//            if (!Storage::exists('product_records/' . Carbon::parse($date)->format('Y_m_d') . ".json")) {
//                Artisan::call("record:products");
//            }
//
//            return $this
//                ->paginate($this->getRecord($date), $request->post('per_page') ?? 30)
//                ->setPath(\request()->url());
 *  private function getRecord(string $date)
    {
        if (!Storage::exists('product_records/' . Carbon::parse($date)->format('Y_m_d') . ".json")) {
            return [];
        }
        return json_decode(Storage::get('product_records/' . Carbon::parse($date)->format('Y_m_d') . ".json"));
    }

    private function paginate($items, $perPage = 100, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $collection = new LengthAwarePaginator(
            array_slice($items, max(0, ($page - 1) * $perPage), $perPage),
            count($items),
            $perPage,
            $page,
            $options
        );
        $products = Product::query()
            ->whereIn('id', $collection->getCollection()->pluck('id'))
            ->select(['id', 'name', 'code', 'unit_id'])
            ->with(['unit:id,name'])
            ->get()
            ->keyBy('id');


        $sale_items = SaleItem::query()
            ->whereIn('product_id', $collection->getCollection()->pluck('id'))
            ->whereDate("created_at", "=", $this->date)
            ->groupBy('product_id')
            ->select([
                "product_id",
                DB::raw("SUM(quantity) as sales_quantity"),
                DB::raw("SUM(total) as sales_payable"),
            ])
            ->get()
            ->keyBy('product_id');

        $yesterday_data = Collection::make(
            $this->getRecord(Carbon::parse($this->date)->addDays(-1)->format('Y-m-d'))
        )->keyBy('id');


        $collection->getCollection()->transform(function ($item) use ($yesterday_data, $sale_items, $products) {
            $the_item = $products->get($item->id);
            $sale_item = $sale_items->get($item->id);
            $previous_data = $yesterday_data->get($item->id);
            $item->name = $the_item->name;
            $item->code = $the_item->code;
            $item->unit = $the_item->unit;
            $item->sales_quantity = $sale_item ? $sale_item->sales_quantity : 0;
            $item->sales_payable = $sale_item ? $sale_item->sales_payable : 0;
            $item->previous_quantity = $previous_data ? $previous_data->quantity : null;
            return $item;
        });
        return $collection;
    }


 */

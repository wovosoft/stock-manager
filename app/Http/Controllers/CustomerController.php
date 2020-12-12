<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Traits\Crud;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class CustomerController extends Controller
{
    protected string $model = Customer::class;
    public array $search_selects;
    public array $search_fields;
    private string $payable, $paid, $returned;
    private bool $withDues = false;

    public function __construct()
    {
        $this->payable = DB::table("sales")
            ->where("sales.customer_id", "=", DB::raw("customers.id"))
            ->whereNull("sales.deleted_at")
            ->selectRaw("IFNULL(SUM(sales.payable),0)")
            ->toSql();

        $this->returned = DB::table("sale_returns")
            ->where("sale_returns.customer_id", "=", DB::raw("customers.id"))
            ->whereNull("sale_returns.deleted_at")
            ->selectRaw("IFNULL(SUM(sale_returns.amount),0)")
            ->toSql();

        $this->paid = DB::table('sale_payments')
            ->where("sale_payments.customer_id", "=", DB::raw("customers.id"))
            ->whereNull("sale_payments.deleted_at")
            ->selectRaw("IFNULL(SUM(sale_payments.payment_amount),0)")
            ->toSql();

        $this->search_selects = $this->search_fields = [
            'id',
            'name',
            'email',
            'phone',
            'company',
            'district',
            'thana',
            'post_office',
            'village',
            'shipping_address',
            'shipping_address',
            "balance" => function (Builder $builder) {
                $builder->selectRaw("($this->payable) - ($this->paid) - ($this->returned)");
            },
        ];
    }

    use Crud;


    public static function routes()
    {
        Route::name('Customers.')->prefix('customers')->group(function () {
            Route::post("list", [self::class, 'list'])->name('List');
            Route::get("export_balances", [self::class, 'exportBalances'])->name('ExportBalances');
            Route::match(['get', 'post'], "input_balances", [self::class, 'inputBalances'])->name('InputBalances');
            Route::post("list/with/dues", [self::class, 'listWithDues'])->name('ListWithDues');
            Route::post("customer/exact/{id}", [self::class, 'getById'])->name('GetByID');
            Route::post("{customer}/returns", [self::class, 'returns'])->name('Returns');
            Route::post("{customer}/payments", [self::class, 'payments'])->name('Payments');
            Route::post("search", [self::class, 'search'])->name('Search');
            Route::post("search/with/dues", [self::class, 'searchWithDues'])->name('SearchWithDues');
            Route::post("store", [self::class, 'store'])->name('Store');
            Route::post("delete", [self::class, 'delete'])->name('Delete');
            Route::post("{customer}/add_fund", [self::class, 'addPayment'])->name('Payments.Add');
            Route::get("{customer}/shortFinancialReport/{type?}", [self::class, 'shortFinancialReport'])->name('Payments.shortFinancialReport');
            Route::get("{customer}/fullFinancialReport/{type?}", [self::class, 'fullFinancialReport'])->name('Payments.fullFinancialReport');
        });
    }

    public function getById($id, Request $request)
    {
        return Customer::query()->select($this->search_selects)->findOrFail($id);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $item = Customer::query()->findOrNew($request->post('id'));
            $item->forceFill([
                "name" => $request->post('name'),
                "email" => $request->post('email'),
                "phone" => $request->post('phone'),
                "company" => $request->post('company'),
                "district" => $request->post('district'),
                "thana" => $request->post('thana'),
                "post_office" => $request->post('post_office'),
                "village" => $request->post('village'),
                "shipping_address" => $request->post('shipping_address')
            ]);

            if ($request->hasFile('photo_upload')) {
                $item->photo = $request->file('photo_upload')->store('photos', 'public');
            } else {
                $item->photo = $request->post("photo");
            }

            $item->saveOrFail();
            DB::commit();
            return successResponse([
                "item" => $item
            ]);
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function addPayment(Customer $customer, Request $request)
    {
        try {
            $request->validate([
                "payment_amount" => "required"
            ]);

            $customer->addPayment(
                $request->post('payment_amount'),
                $request->post('payment_method'),
                $request->post('bank'),
                $request->post('check'),
                $request->post('transaction_no')
            );
            return successResponse();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function listWithDues(Request $request)
    {
        try {
            $this->withDues = true;
            return $this->list($request);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function inputBalances(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('pages.importer.customer_balance');
        }
        try {
            $request->validate([
                "items" => ["required", "json"],
                "fake_product" => ["required", "numeric"]
            ]);
            DB::beginTransaction();
            $items = json_decode($request->post('items'));
            foreach ($items as $item) {
                if ($item->balance > 0.1) {
                    $sale = new Sale();
                    $sale
                        ->forceFill([
                            "customer_id" => $item->id,
                            "tax" => 0,
                            "discount" => 0,
                            "date" => Carbon::now()->format('Y-m-d'),
                            "status" => "Processed",
                            "note" => null,
                            "paid" => 0,
                            "total" => $item->balance,
                            "payable" => $item->balance,
                            "previous_balance" => 0,
                            "current_balance" => $item->balance,
                        ])
                        ->saveOrFail();

                    (new SaleItem())
                        ->forceFill([
                            "sale_id" => $sale->id,
                            "product_id" => $request->post('fake_product'),
                            "customer_id" => $sale->customer_id,
                            "quantity" => 1,
                            "price" => $item->balance,
                        ])
                        ->saveOrFail();
                }
            }
            DB::commit();
            return successResponse();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function exportBalances(Request $request)
    {
        try {
            $items = Customer::query()->select([
                "customers.id",
                DB::raw("round(($this->payable),2) as payable"),
                DB::raw("round(($this->paid),2) as paid"),
                DB::raw("round(($this->returned),2) as returned"),
                "balance" => function (Builder $builder) {
                    $builder->selectRaw("round((payable - paid - returned),2)");
                },
            ]);
            return response()->json($items->get());
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function list(Request $request)
    {
        try {
            $items = Customer::query()->select(array_merge(["customers.*",], [
                DB::raw("($this->payable) as payable"),
                DB::raw("($this->paid) as paid"),
                DB::raw("($this->returned) as returned"),
                "balance" => function (Builder $builder) {
                    $builder->selectRaw("payable - paid - returned");
                },
            ]));
            if ($this->withDues) {
                //because .0001 can be remain as balance. we use 0.1 rather than 0.0
                $items->having('balance', '>', 0.1);
            }
            if ($request->has('id')) {
                return $items->findOrFail($request->post('id'));
            }

            return response()
                ->json($items->defaultDatatable($request))
                ->header("fund_summery", json_encode(
                    resetQueryForOverview($items)
                        ->whereNull('customers.deleted_at')
                        ->select([
                            DB::raw("SUM(IFNULL(($this->payable),0)) as payable"),
                            DB::raw("SUM(IFNULL(($this->returned),0))  as returned"),
                            DB::raw("SUM(IFNULL(($this->paid),0))  as paid"),
                            DB::raw("SUM(IFNULL(($this->payable) - ($this->returned) - ($this->paid),0))  as balance"),
                        ])
                        ->first()
                ));
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function payments(Customer $customer, Request $request)
    {
        try {
            return $customer->salePayments()
                ->leftJoin("customers", 'customers.id', '=', 'sale_payments.customer_id')
                ->select([
                    "customers.name",
                    "sale_payments.*"
                ])
                ->defaultDatatable($request);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function shortFinancialReport($customer_id, string $type = "pdf", Request $request)
    {
        try {
            $start_date = ($request->has('start_date') && $request->input('start_date')) ? $request->input('start_date') : null;
            $end_date = ($request->has('end_date') && $request->input('end_date')) ? $request->input('end_date') : null;


            $customer = Customer::query()
                ->select([
                    "customers.*",
                    "payable" => function (Builder $builder) use ($end_date, $start_date) {
                        $builder->from("sales")
                            ->where("sales.customer_id", "=", DB::raw("customers.id"))
                            ->whereNull("sales.deleted_at")
                            ->selectRaw("IFNULL(SUM(sales.payable),0)");
                        if ($start_date) {
                            $builder->whereDate('created_at', '>=', $start_date);
                        }
                        if ($end_date) {
                            $builder->whereDate('created_at', '<=', $end_date);
                        }
                    },
                    "paid" => function (Builder $builder) use ($end_date, $start_date) {
                        $builder->from('sale_payments')
                            ->where("sale_payments.customer_id", "=", DB::raw("customers.id"))
                            ->whereNull("sale_payments.deleted_at")
                            ->selectRaw("IFNULL(SUM(sale_payments.payment_amount),0)");
                        if ($start_date) {
                            $builder->whereDate('created_at', '>=', $start_date);
                        }
                        if ($end_date) {
                            $builder->whereDate('created_at', '<=', $end_date);
                        }
                    },
                    "returned" => function (Builder $builder) use ($end_date, $start_date) {
                        $builder->from("sale_returns")
                            ->where("sale_returns.customer_id", "=", DB::raw("customers.id"))
                            ->whereNull("sale_returns.deleted_at")
                            ->selectRaw("IFNULL(SUM(sale_returns.amount),0)");
                        if ($start_date) {
                            $builder->whereDate('created_at', '>=', $start_date);
                        }
                        if ($end_date) {
                            $builder->whereDate('created_at', '<=', $end_date);
                        }
                    },
                    DB::raw("(select (payable - returned - paid)) as balance")
                ])
                ->findOrFail($customer_id);

            if ($type == 'html') {
                return view("pages.customers.short_financial_report", [
                    "customer" => $customer,
                    "start_date" => $start_date ? Carbon::parse($start_date)->locale('bn-BD') : null,
                    "end_date" => $end_date ? Carbon::parse($end_date)->locale('bn-BD') : null
                ]);
            }

            return \PDF::loadView('pages.customers.short_financial_report', [
                "customer" => $customer,
                "start_date" => $start_date ? Carbon::parse($start_date)->locale('bn-BD') : null,
                "end_date" => $end_date ? Carbon::parse($end_date)->locale('bn-BD') : null
            ])->stream("customer_short_financial_report-{$customer->id}.pdf");

        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function fullFinancialReport(Customer $customer, string $type = 'pdf', Request $request)
    {
        $start_date = ($request->has('start_date') && $request->get('start_date')) ? $request->get('start_date') : null;
        $end_date = ($request->has('end_date') && $request->get('end_date')) ? $request->get('end_date') : null;
        /**
         * I am confused about debit & credit. so , the reference are as below:
         * resource/money goes to customer => to_customer
         * resource/money coming from customer => from_customer
         */
        try {
            //union fields:  date, to_customer, from_customer

            $payments = $customer
                ->salePayments()
                ->select([
                    DB::raw("'payment' as title"),
                    DB::raw("created_at as date"),
                    DB::raw("0 as to_customer"),
                    DB::raw("payment_amount as from_customer")
                ]);
            $returns = $customer
                ->saleReturns()
                ->select([
                    DB::raw("'return' as title"),
                    DB::raw("created_at as date"),
                    DB::raw("0 as to_customer"),
                    DB::raw("amount as from_customer")
                ]);

            $records = $customer
                ->sales()
                ->select([
                    DB::raw("'sale' as title"),
                    DB::raw("created_at as date"),
                    DB::raw("payable as to_customer"),
                    DB::raw("0 as from_customer")
                ]);
            if ($start_date) {
                $payments->whereDate('created_at', '>=', $start_date);
                $returns->whereDate('created_at', '>=', $start_date);
                $records->whereDate('created_at', '>=', $start_date);
            }
            if ($end_date) {
                $payments->whereDate('created_at', '<=', $end_date);
                $returns->whereDate('created_at', '<=', $end_date);
                $records->whereDate('created_at', '<=', $end_date);
            }

            if ($type == 'html') {
                return view("pages.customers.full_financial_report", [
                    "customer" => $customer,
                    "records" => $records
                        ->union($payments)
                        ->union($returns)
                        ->orderBy('date', 'asc')
                        ->get(),
                    "start_date" => $start_date ? Carbon::parse($start_date)->locale('bn-BD') : null,
                    "end_date" => $end_date ? Carbon::parse($end_date)->locale('bn-BD') : null
                ]);
            }

            return \PDF::loadView('pages.customers.full_financial_report', [
                "customer" => $customer,
                "records" => $records
                    ->union($payments)
                    ->union($returns)
                    ->orderBy('date', 'asc')
                    ->get(),
                "start_date" => $start_date ? Carbon::parse($start_date)->locale('bn-BD') : null,
                "end_date" => $end_date ? Carbon::parse($end_date)->locale('bn-BD') : null
            ])->stream("customer_short_financial_report-{$customer->id}.pdf");

        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function returns(Customer $customer, Request $request)
    {
        try {
            return $customer
                ->saleReturns()
                ->leftJoin("customers", "customers.id", "=", "sale_returns.customer_id")
                ->leftJoin("products", "products.id", "=", "sale_returns.product_id")
                ->select([
                    "sale_returns.*",
                    DB::raw("customers.name as customer_name"),
                    DB::raw("products.name as product_name"),
                ])
                ->defaultDatatable($request);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function searchWithDues(Request $request)
    {
        try {
            $payable = DB::table("sales")
                ->where("sales.customer_id", "=", DB::raw("customers.id"))
                ->whereNull("sales.deleted_at")
                ->selectRaw("IFNULL(SUM(sales.payable),0)")
                ->toSql();

            $returned = DB::table("sale_returns")
                ->where("sale_returns.customer_id", "=", DB::raw("customers.id"))
                ->whereNull("sale_returns.deleted_at")
                ->selectRaw("IFNULL(SUM(sale_returns.amount),0)")
                ->toSql();

            $paid = DB::table('sale_payments')
                ->where("sale_payments.customer_id", "=", DB::raw("customers.id"))
                ->whereNull("sale_payments.deleted_at")
                ->selectRaw("IFNULL(SUM(sale_payments.payment_amount),0)")
                ->toSql();
            $items = Customer::query()
                ->select([
                    "customers.id",
                    "customers.name",
                    "customers.phone",
                    "customers.company",
                    "customers.village",
                    DB::raw("(($payable) - ($paid) - ($returned)) as balance")
                ])
                ->limit($request->post('limit') ?? 30);

            if ($request->post('query')) {
                $items
                    ->where('id', '=', $request->post('query'))
                    ->orWhere('name', 'like', '%' . $request->post('query') . '%')
                    ->orWhere('company', 'like', '%' . $request->post('query') . '%')
                    ->orWhere('phone', 'like', '%' . $request->post('query') . '%');
            }
            return $items->get();
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}


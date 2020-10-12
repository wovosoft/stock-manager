<?php

namespace App\Builders;


use App\Models\CapitalDeposit;
use App\Models\CapitalWithdraw;
use App\Models\CustomerFund;
use App\Models\Employee;
use App\Models\EmployeeSalary;
use App\Models\Expense;
use App\Models\Purchase;
use App\Models\PurchasePayment;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\SalePayment;
use App\User;
use Illuminate\Support\Facades\DB;

class Reports
{
    private ?string $starting_date, $ending_date;
    private float $deposit_amount, $deposit_quantity, $withdrawal_amount,
        $withdrawal_quantity, $sales_payable_amount, $sales_quantity,
        $sales_paid_amount, $purchases_payable_amount, $purchases_paid_amount,
        $purchases_quantity, $expenses_amount, $expenses_quantity;
    private bool $to_json;

    public function __construct(?string $starting_date = null, ?string $ending_date = null)
    {
        $this->starting_date = $starting_date;
        $this->ending_date = $ending_date;
        $this->to_json = false;
    }

    /**
     * @return int|mixed
     * @throws \Throwable
     */
    public function depositAmount()
    {
        try {
            if (isset($this->deposit_amount)) {
                return $this->deposit_amount;
            }
            return CapitalDeposit::query()->sum('payment_amount');
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @return int
     * @throws \Throwable
     */
    public function depositQuantity()
    {
        try {
            if (isset($this->deposit_quantity)) {
                return $this->deposit_quantity;
            }
            return CapitalDeposit::query()->count("id");
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @return int|mixed
     * @throws \Throwable
     */
    public function withdrawalAmount()
    {
        try {
            if (isset($this->withdrawal_amount)) {
                return $this->withdrawal_amount;
            }
            return CapitalWithdraw::query()->sum('payment_amount');
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @return int
     * @throws \Throwable
     */
    public function withdrawalQuantity()
    {
        try {
            if (isset($this->withdrawal_quantity)) {
                return $this->withdrawal_quantity;
            }
            return CapitalWithdraw::query()->count('id');
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @return int|mixed
     * @throws \Throwable
     */
    public function capitalBalance()
    {
        try {
            return ($this->depositAmount() - $this->withdrawalAmount());
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * Returns the builder, so need to manually call get,toSql etc
     * @param array $options
     * @throws \Throwable
     */
    public function capitalDebitCredit(array $options = [])
    {
        try {
            $deposits = CapitalDeposit::query()
                ->select([
                    'id',
                    'payment_amount',
                    DB::raw("payment_amount as debit"),
                    DB::raw("0 as credit"),
                    'payment_method',
                    'bank',
                    'check_no',
                    'transaction_no',
                    'created_at',
                    DB::raw("'deposit' as type")
                ]);

            if (isset($options['starting_date']) && $options['starting_date'] && isset($options['ending_date']) && $options['ending_date']) {
                $deposits->whereBetween("capital_deposits.created_at", [$options['starting_date'], $options['ending_date']]);
            } elseif (isset($options['starting_date']) && $options['starting_date'] && !isset($options['ending_date'])) {
                $deposits->whereDate("capital_deposits.created_at", "=", $options['starting_date']);
            } elseif (!isset($options['starting_date']) && isset($options['ending_date']) && $options['ending_date']) {
                $deposits->whereDate("capital_deposits.created_at", "=", $options['ending_date']);
            }
            $withdrawn = CapitalWithdraw::query()
                ->select(['id',
                    'payment_amount',
                    DB::raw("0 as debit"),
                    DB::raw("payment_amount as credit"),
                    'payment_method',
                    'bank',
                    'check_no',
                    'transaction_no',
                    'created_at',
                    DB::raw("'withdrawn' as type")
                ])
                ->union($deposits);

            if (isset($options['starting_date']) && $options['starting_date'] && isset($options['ending_date']) && $options['ending_date']) {
                $withdrawn->whereBetween("capital_withdraws.created_at", [$options['starting_date'], $options['ending_date']]);
            } elseif (isset($options['starting_date']) && $options['starting_date'] && !isset($options['ending_date'])) {
                $withdrawn->whereDate("capital_withdraws.created_at", "=", $options['starting_date']);
            } elseif (!isset($options['starting_date']) && isset($options['ending_date']) && $options['ending_date']) {
                $withdrawn->whereDate("capital_withdraws.created_at", "=", $options['ending_date']);
            }

            return $withdrawn;
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @param int $customer_id
     * @return int|mixed
     * @throws \Throwable
     */
    public function salesPayableAmount(int $customer_id)
    {
        try {
            $items = Sale::query();
            if ($customer_id) {
                $items->where('customer_id', '=', $customer_id);
            }
            return $items->sum('payable');
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @return int
     * @throws \Throwable
     */
    public function salesQuantity()
    {
        try {
            if (isset($this->sales_quantity)) {
                return $this->sales_quantity;
            }
            return Sale::query()->count('id');
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @param int $customer_id
     * @return int|mixed
     * @throws \Throwable
     */
    public function salesPaidAmount(int $customer_id)
    {
        try {
            $items = SalePayment::query();
            if ($customer_id) {
                $items->where('customer_id', '=', $customer_id);
            }
            return $items->sum('payment_amount');
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function toJson(bool $toJson = true)
    {
        $this->to_json = !!$toJson;
        return $this;
    }

    public function salesOverview(array $options = [])
    {
        try {
            $item = DB::table("sales")
                ->select([
                    DB::raw("SUM(payable) as sales_payable"),
                    DB::raw("SUM(paid) as sales_paid"),
                    DB::raw("(SUM(payable) - SUM(paid)) as sales_balance"),
                ]);

            if (isset($options['starting_date']) && $options['starting_date'] && isset($options['ending_date']) && $options['ending_date']) {
                $item->whereBetween("created_at", [$options['starting_date'], $options['ending_date']]);
            } elseif (isset($options['starting_date']) && $options['starting_date'] && !isset($options['ending_date'])) {
                $item->whereDate("created_at", "=", $options['starting_date']);
            } elseif (!isset($options['starting_date']) && isset($options['ending_date']) && $options['ending_date']) {
                $item->whereDate("created_at", "=", $options['ending_date']);
            }

            return $item;
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }


    public function listSales(array $options = [])
    {
        try {
            $items = Sale::query()
                ->leftJoin("customers", "customers.id", "=", "sales.customer_id")
                ->select([
                    "sales.id",
                    "sales.customer_id",
                    DB::raw("customers.name as customer_name"),
                    "sales.total",
                    "sales.payable",
                    "sales.paid",
                    "sales.balance",
                    DB::raw("(sales.total * sales.tax/100) as tax"),
                    "sales.discount",
                    "sales.created_at",
                ]);

            if (isset($options['starting_date']) && $options['starting_date'] && isset($options['ending_date']) && $options['ending_date']) {
                $items->whereBetween("sales.created_at", [$options['starting_date'], $options['ending_date']]);
            } elseif (isset($options['starting_date']) && $options['starting_date'] && !isset($options['ending_date'])) {
                $items->whereDate("sales.created_at", "=", $options['starting_date']);
            } elseif (!isset($options['starting_date']) && isset($options['ending_date']) && $options['ending_date']) {
                $items->whereDate("sales.created_at", "=", $options['ending_date']);
            }


            return $items;
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function listSaleItems(array $options = [])
    {
        try {
            $items = SaleItem::query()
                ->leftJoin("customers", "customers.id", '=', "sale_items.customer_id")
                ->leftJoin("products", "products.id", '=', "sale_items.product_id")
                ->orderBy("sale_id");


            if (isset($options['starting_date']) && $options['starting_date'] && isset($options['ending_date']) && $options['ending_date']) {
                $items->whereBetween("sale_items.created_at", [$options['starting_date'], $options['ending_date']]);
            } elseif (isset($options['starting_date']) && $options['starting_date'] && !isset($options['ending_date'])) {
                $items->whereDate("sale_items.created_at", "=", $options['starting_date']);
            } elseif (!isset($options['starting_date']) && isset($options['ending_date']) && $options['ending_date']) {
                $items->whereDate("sale_items.created_at", "=", $options['ending_date']);
            }

            $items->select([
                "sale_items.*",
                DB::raw("customers.name as customer_name"),
                DB::raw("products.name as product_name")
            ]);


            return $items;
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function listSaleProducts(array $options = [])
    {
        try {
            $items = SaleItem::query()
                ->leftJoin("products", "products.id", "=", "sale_items.product_id")
                ->select([
                    "sale_items.product_id",
                    "products.name",
                    DB::raw("SUM(IFNULL(sale_items.quantity,0)) as quantity"),
                    DB::raw("COUNT(sale_items.customer_id) as customers"),
                    DB::raw("COUNT(sale_items.sale_id) as sales"),
                    DB::raw("SUM(IFNULL(sale_items.total,0)) as total"),
                    DB::raw("SUM(IFNULL(sale_items.total,0) * IFNULL(sale_items.tax,0) /100) as tax"),
                    DB::raw("SUM(IFNULL(sale_items.total,0) * IFNULL(sale_items.discount,0) /100) as discount"),
                    DB::raw("SUM(IFNULL(sale_items.payable,0)) as payable")
                ])
                ->groupBy("sale_items.product_id");

            if (isset($options['starting_date']) && $options['starting_date'] && isset($options['ending_date']) && $options['ending_date']) {
                $items->whereBetween("sale_items.created_at", [$options['starting_date'], $options['ending_date']]);
            } elseif (isset($options['starting_date']) && $options['starting_date'] && !isset($options['ending_date'])) {
                $items->whereDate("sale_items.created_at", "=", $options['starting_date']);
            } elseif (!isset($options['starting_date']) && isset($options['ending_date']) && $options['ending_date']) {
                $items->whereDate("sale_items.created_at", "=", $options['ending_date']);
            }

            return $items;
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function customerBalance(int $customer_id)
    {
        try {
            return $this->customerFundBalance($customer_id) - $this->salesDueAmount($customer_id);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function listSaleByCustomer(array $options = [])
    {
        try {
            $items = Sale::query()
                ->leftJoin("customers", "customers.id", "=", "sales.customer_id")
                ->select([
                    "sales.customer_id",
                    DB::raw("customers.name as customer_name"),
                    DB::raw("COUNT(sales.id) as sales_quantity"),
                    DB::raw("SUM(sales.total) as sales_total"),
                    DB::raw("SUM(sales.total * sales.tax/100) as sales_tax"),
                    DB::raw("SUM(sales.total * sales.discount/100) as sales_discount"),
                    DB::raw("SUM(sales.payable) as sales_payable"),
                    DB::raw("SUM(sales.paid) as sales_paid"),
                    DB::raw("SUM(sales.balance) as sales_balance"),
                ])
                ->groupBy("sales.customer_id");

            if (isset($options['starting_date']) && $options['starting_date'] && isset($options['ending_date']) && $options['ending_date']) {
                $items->whereBetween("sales.created_at", [$options['starting_date'], $options['ending_date']]);
            } elseif (isset($options['starting_date']) && $options['starting_date'] && !isset($options['ending_date'])) {
                $items->whereDate("sales.created_at", "=", $options['starting_date']);
            } elseif (!isset($options['starting_date']) && isset($options['ending_date']) && $options['ending_date']) {
                $items->whereDate("sales.created_at", "=", $options['ending_date']);
            }

            return $items;
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @return int|mixed
     * @throws \Throwable
     */
    public function salesDueAmount(int $customer_id)
    {
        try {
            return ($this->salesPayableAmount($customer_id) - $this->salesPaidAmount($customer_id));
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @return int|mixed
     * @throws \Throwable
     */
    public function profitableAmount()
    {
        try {
            return $this->salesPayableAmount() - $this->purchasesPayableAmount();
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @return int|mixed
     * @throws \Throwable
     */
    public function profitAmount()
    {
        try {
            return $this->salesPaidAmount() - $this->purchasesPaidAmount();
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @return int|mixed
     * @throws \Throwable
     */
    public function purchasesPayableAmount()
    {
        try {
            if (isset($this->purchases_payable_amount)) {
                return $this->purchases_payable_amount;
            }
            return Purchase::query()->sum('payable');
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @return int|mixed
     * @throws \Throwable
     */
    public function purchasesPaidAmount()
    {
        try {
            if (isset($this->purchases_paid_amount)) {
                return $this->purchases_paid_amount;
            }
            return PurchasePayment::query()->sum('payment_amount');
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @return int
     * @throws \Throwable
     */
    public function purchasesQuantity()
    {
        try {
            if (isset($this->purchases_quantity)) {
                return $this->purchases_quantity;
            }
            return Purchase::query()->count('id');
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function purchasesOverview()
    {
        try {
            $item = DB::table("purchases")
                ->select([
                    DB::raw("SUM(payable) as purchases_payable"),
                    DB::raw("SUM(paid) as purchases_paid"),
                    DB::raw("(SUM(payable) - SUM(paid)) as purchases_balance"),
                ])
                ->first();
            return $this->to_json ? json_encode($item) : $item;
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @return int|mixed
     * @throws \Throwable
     */
    public function expensesAmount()
    {
        try {
            if (isset($this->expenses_amount)) {
                return $this->expenses_amount;
            }
            return Expense::query()->sum("amount");
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    /**
     * @return int
     * @throws \Throwable
     */
    public function expensesQuantity()
    {
        try {
            if (isset($this->expenses_quantity)) {
                return $this->expenses_quantity;
            }
            return Expense::query()->count("id");
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function totalAvailableBalance()
    {
        try {
            return (
                $this->depositAmount()
                - $this->withdrawalAmount()
                - $this->expensesAmount()
                + $this->salesPaidAmount()
                - $this->purchasesPaidAmount()
            );
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function customerFundDeposits(?int $customer_id = null)
    {
        try {
            $items = CustomerFund::query()
                ->where("type", "=", "deposit")
                ->select("payment_amount");
            if ($customer_id) {
                $items->where("customer_id", "=", $customer_id);
            }
            return $items->sum("payment_amount");
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function customerFundWithdrawn(?int $customer_id = null)
    {
        try {
            $items = CustomerFund::query()
                ->where("type", "=", "withdrawn")
                ->select("payment_amount");
            if ($customer_id) {
                $items->where("customer_id", "=", $customer_id);
            }
            return $items->sum("payment_amount");
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function customerFundBalance(?int $customer_id = null)
    {
        try {
            return ($this->customerFundDeposits($customer_id) - $this->customerFundWithdrawn($customer_id));
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function customerFundSummery(?int $customer_id = null)
    {
        try {
            $cd_sql = DB::table('customer_funds')
                ->select([DB::raw("IFNULL(SUM(payment_amount),0)")])
                ->where("type", "=", "deposit")
                ->whereNull("deleted_at");

            $cw_sql = DB::table('customer_funds')
                ->select([DB::raw("IFNULL(SUM(payment_amount),0)")])
                ->where("type", "=", "withdrawn")
                ->whereNull("deleted_at");
            if ($customer_id) {
                $cd_sql->where("customer_id", "=", $customer_id);
                $cw_sql->where("customer_id", "=", $customer_id);
            }
            $customer_deposits = $this->getSqlWithBindings($cd_sql);

            $customer_withdrawn = $this->getSqlWithBindings($cw_sql);


            $customer_balance = "($customer_deposits)-($customer_withdrawn)";

            return User::query()
                ->selectRaw("($customer_deposits) as deposit")
                ->selectRaw("($customer_withdrawn) as withdrawn")
                ->selectRaw("($customer_balance) as balance")
                ->first();

        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function supplierFundSummery(?int $supplier_id = null)
    {
        try {
            $d_sql = DB::table('supplier_funds')
                ->select([DB::raw("IFNULL(SUM(payment_amount),0)")])
                ->where("type", "=", "deposit")
                ->whereNull("deleted_at");

            $w_sql = DB::table('supplier_funds')
                ->select([DB::raw("IFNULL(SUM(payment_amount),0)")])
                ->where("type", "=", "withdrawn")
                ->whereNull("deleted_at");
            if ($supplier_id) {
                $d_sql->where("supplier_id", "=", $supplier_id);
                $w_sql->where("supplier_id", "=", $supplier_id);
            }
            $deposits = $this->getSqlWithBindings($d_sql);

            $withdrawn = $this->getSqlWithBindings($w_sql);


            $balance = "($deposits)-($withdrawn)";

            return User::query()
                ->selectRaw("($deposits) as deposit")
                ->selectRaw("($withdrawn) as withdrawn")
                ->selectRaw("($balance) as balance")
                ->first();

        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function employeeSalarySummery(?int $employee_id = null)
    {
        try {
            $items = EmployeeSalary::query()
                ->select(["payment_amount"]);

            if ($employee_id) {
                $items->where("employee_id", "=", $employee_id);
            }
            return json_encode([
                "payment_amount" => $items->sum("payment_amount"),
                "total_pay_number" => $items->count("id"),
                "total_employees" => Employee::query()->count("id")
            ]);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }


    private function getSqlWithBindings($query)
    {
        return vsprintf(str_replace('?', '%s', $query->toSql()), collect($query->getBindings())->map(function ($binding) {
            return is_numeric($binding) ? $binding : "'{$binding}'";
        })->toArray());
    }


    public function summery()
    {
        try {
            $capital_deposits = DB::table("capital_deposits")
                ->select([DB::raw("IFNULL(SUM(payment_amount),0)")])
                ->whereNull("deleted_at")
                ->toSql();

            $capital_withdrawn = DB::table("capital_withdraws")
                ->select([DB::raw("IFNULL(SUM(payment_amount),0)")])
                ->whereNull("deleted_at")
                ->toSql();

            $sales_payable = DB::table("sales")
                ->select([DB::raw("IFNULL(SUM(payable),0)")])
                ->whereNull("deleted_at")
                ->toSql();

            $sales_paid = DB::table("sale_payments")
                ->select([DB::raw("IFNULL(SUM(payment_amount),0)")])
                ->whereNull("deleted_at")
                ->toSql();
            $purchases_payable = DB::table("purchases")
                ->select([DB::raw("IFNULL(SUM(payable),0)")])
                ->whereNull("deleted_at")
                ->toSql();

            $purchases_paid = DB::table("purchase_payments")
                ->select([DB::raw("IFNULL(SUM(payment_amount),0)")])
                ->whereNull("deleted_at")
                ->toSql();

            $expenses_amount = DB::table("expenses")
                ->select([DB::raw("IFNULL(SUM(amount),0)")])
                ->whereNull("deleted_at")
                ->toSql();

            $employee_salary = DB::table('employee_salaries')
                ->select([DB::raw("IFNULL(SUM(payment_amount),0)")])
                ->whereNull("deleted_at")
                ->toSql();

            $customer_deposits = $this->getSqlWithBindings(DB::table('customer_funds')
                ->select([DB::raw("IFNULL(SUM(payment_amount),0)")])
                ->where("type", "=", "deposit")
                ->whereNull("deleted_at"));

            $customer_withdrawn = $this->getSqlWithBindings(DB::table('customer_funds')
                ->select([DB::raw("IFNULL(SUM(payment_amount),0)")])
                ->where("type", "=", "withdrawn")
                ->whereNull("deleted_at"));
            $customer_balance = "($customer_deposits)-($customer_withdrawn)";

            $supplier_deposits = $this->getSqlWithBindings(DB::table('supplier_funds')
                ->select([DB::raw("IFNULL(SUM(payment_amount),0)")])
                ->where("type", "=", "deposit")
                ->whereNull("deleted_at"));

            $supplier_withdrawn = $this->getSqlWithBindings(DB::table('supplier_funds')
                ->select([DB::raw("IFNULL(SUM(payment_amount),0)")])
                ->where("type", "=", "withdrawn")
                ->whereNull("deleted_at"));
            $supplier_balance = "($supplier_withdrawn)-($supplier_deposits)";


            $available_cash = implode("-", [
                "($capital_deposits)",
                "($capital_withdrawn) + ($sales_paid)",
                "($purchases_paid)",
                "($expenses_amount)",
                "($employee_salary) + ($customer_balance)+($supplier_balance)"
            ]);
            return User::query()
                ->selectRaw("($capital_deposits) as capital_deposited")
                ->selectRaw("($capital_withdrawn) as capital_withdrawn")
                ->selectRaw("(($capital_deposits) - ($capital_withdrawn)) as capital_balance")
                ->selectRaw("($customer_deposits) as customer_funds_deposits")
                ->selectRaw("($customer_withdrawn) as customer_funds_withdrawn")
                ->selectRaw("($customer_balance) as customer_funds_balance")
                ->selectRaw("($supplier_deposits) as supplier_funds_deposit")
                ->selectRaw("($supplier_withdrawn) as supplier_funds_withdrawn")
                ->selectRaw("($supplier_balance) as supplier_funds_balance")
                ->selectRaw("($sales_payable) as sales_payable")
                ->selectRaw("($sales_paid) as sales_paid")
                ->selectRaw("(($sales_payable) - ($sales_paid)) as sales_due")
                ->selectRaw("($purchases_payable) as purchases_payable")
                ->selectRaw("($purchases_paid) as purchases_paid")
                ->selectRaw("(($purchases_payable) - ($purchases_paid)) as purchases_due")
                ->selectRaw("($expenses_amount) as expenses_amount")
                ->selectRaw("($employee_salary) as employee_salaries")
                ->selectRaw("($available_cash) as cash_available")
                ->first();
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function productsSummeryInCurrentPrice()
    {
        try {
            return DB::table("products")
                ->selectRaw("SUM(cost * quantity) as cost")
                ->selectRaw("SUM(price * quantity) as price")
                ->selectRaw("(SUM(price * quantity)-SUM(cost * quantity)) as balance")
                ->first();
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}

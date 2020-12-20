<?php

namespace App\Models;


use App\Builders\Reports;
use App\Traits\HistoryTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Customer extends BaseModel
{
    use HistoryTrait;
    use HasFactory;

//    protected $appends = ["photo_url"];
//
//    public function getPhotoUrlAttribute()
//    {
//        if (filter_var($this->photo, FILTER_VALIDATE_URL) === FALSE) {
//            return asset("storage/" . $this->photo);
//        }
//        return $this->photo;
//    }
    public function addPayment(
        float $payment_amount,
        ?string $payment_method = "Cash",
        ?string $bank = null,
        ?string $check = null,
        ?string $transaction_no = null,
        ?bool $isCashCollection = false,
        ?string $created_at = null
    )
    {
        try {
            DB::beginTransaction();
            $payment = new SalePayment();
            $payment->forceFill([
                "customer_id" => $this->id,
                "payment_method" => $payment_method,
                "payment_amount" => $payment_amount,
                "bank" => $bank,
                "check" => $check,
                "transaction_no" => $transaction_no,
                "is_cash_collection" => $isCashCollection ?? false,
                "created_at" => $created_at ?? Carbon::now()->toDateTimeString()
            ]);

            $payment->saveOrFail();
            DB::commit();
            return $payment;
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function getCurrentBalanceAttribute()
    {
        $payable = DB::table("sales")
            ->where("sales.customer_id", "=", DB::raw($this->id))
            ->whereNull("sales.deleted_at")
            ->selectRaw("IFNULL(SUM(sales.payable),0)")
            ->toSql();

        $returned = DB::table("sale_returns")
            ->where("sale_returns.customer_id", "=", DB::raw($this->id))
            ->whereNull("sale_returns.deleted_at")
            ->selectRaw("IFNULL(SUM(sale_returns.amount),0)")
            ->toSql();

        $paid = DB::table('sale_payments')
            ->where("sale_payments.customer_id", "=", DB::raw($this->id))
            ->whereNull("sale_payments.deleted_at")
            ->selectRaw("IFNULL(SUM(sale_payments.payment_amount),0)")
            ->toSql();
        return self::query()
            ->select([
                DB::raw("SUM(($payable) - ($paid) - ($returned)) as the_balance")
            ])
            ->findOrFail($this->id)
            ->the_balance;

    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'customer_id', 'id');
    }

    public function salePayments()
    {
        return $this->hasMany(SalePayment::class, 'customer_id');
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class, 'customer_id');
    }

    public function saleReturns()
    {
        return $this->hasMany(SaleReturn::class, 'customer_id');
    }

    public function funds()
    {
        return $this->hasMany(CustomerFund::class, 'customer_id', 'id');
    }

    public function accountBalance()
    {
        return (new Reports())->customerBalance($this->id);
    }
}

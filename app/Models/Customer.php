<?php

namespace App\Models;


use App\Builders\Reports;
use App\Traits\HistoryTrait;
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
        ?string $transaction_no = null
    )
    {
        try {
            DB::beginTransaction();
            $payment = new SalePayment();
            $payment->customer_id = $this->id;
            $payment->payment_method = $payment_method;
            $payment->payment_amount = $payment_amount;
            $payment->bank = $bank;
            $payment->check = $check;
            $payment->transaction_no = $transaction_no;
            $payment->saveOrFail();
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
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

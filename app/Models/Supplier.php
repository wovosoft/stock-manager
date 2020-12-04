<?php

namespace App\Models;


use App\Traits\HistoryTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Supplier extends BaseModel
{
    use HistoryTrait, HasFactory;

//    protected $appends = ["photo_url"];

    public function getPhotoUrlAttribute()
    {
        if (filter_var($this->photo, FILTER_VALIDATE_URL) === FALSE) {
            return asset("storage/" . $this->photo);
        }
        return $this->photo;
    }

    /**
     * @param float $payment_amount
     * @param string|null $payment_method
     * @param string|null $bank
     * @param string|null $check
     * @param string|null $transaction_no
     * For the first payment which is made along with the purchase,
     * it doesn't shows invoice properly because, both timestamps for the purchase
     * and payment are same. To fix this issue created_at should be made few milliseconds later,
     * so that current balance and previous balance can be calculated properly depending on the time.
     * @param string|null $created_at
     * @throws \Throwable
     */
    public function addPayment(
        float $payment_amount,
        ?string $payment_method = "Cash",
        ?string $bank = null,
        ?string $check = null,
        ?string $transaction_no = null,
        ?string $created_at = null
    )
    {
        try {
            DB::beginTransaction();
            $payment = new PurchasePayment();
            $payment->forceFill([
                "supplier_id" => $this->id,
                "payment_method" => $payment_method,
                "payment_amount" => $payment_amount,
                "bank" => $bank,
                "check" => $check,
                "transaction_no" => $transaction_no,
                "created_at" => $created_at ?? Carbon::now()->toDateTimeString()
            ]);
            $payment->saveOrFail();
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function getCurrentBalanceAttribute()
    {
        $payable = DB::table("purchases")
            ->where("purchases.supplier_id", "=", DB::raw($this->id))
            ->whereNull("purchases.deleted_at")
            ->selectRaw("IFNULL(SUM(purchases.payable),0)")
            ->toSql();

        $returned = DB::table("purchase_returns")
            ->where("purchase_returns.supplier_id", "=", DB::raw($this->id))
            ->whereNull("purchase_returns.deleted_at")
            ->selectRaw("IFNULL(SUM(purchase_returns.amount),0)")
            ->toSql();

        $paid = DB::table('purchase_payments')
            ->where("purchase_payments.supplier_id", "=", DB::raw($this->id))
            ->whereNull("purchase_payments.deleted_at")
            ->selectRaw("IFNULL(SUM(purchase_payments.payment_amount),0)")
            ->toSql();

        return self::query()
            ->select([
                DB::raw("SUM(($payable) - ($paid) - ($returned)) as the_balance")
            ])
            ->findOrFail($this->id)
            ->the_balance;

    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'supplier_id', 'id');
    }

    public function purchasePayments()
    {
        return $this->hasMany(PurchasePayment::class, 'supplier_id');
    }

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class, 'supplier_id');
    }

    public function purchaseReturns()
    {
        return $this->hasMany(PurchaseReturn::class, 'supplier_id');
    }
}

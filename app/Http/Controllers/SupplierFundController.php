<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\SupplierFund;
use App\Traits\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SupplierFundController extends Controller
{
    protected string $model = Supplier::class;
    public array $search_selects = [
        'id',
        'supplier_id',
        'payment_amount',
        'payment_method',
        'date',
        'created_at'
    ];
    public array $search_fields = [
        'id',
        'supplier_id',
        'payment_amount',
        'payment_method',
        'date',
        'created_at'
    ];
    use Crud;

    public static function routes()
    {
        Route::post("supplier/funds/list", '\\' . __CLASS__ . '@list')->name('Supplier.Funds.List');
        Route::post("supplier/funds/search", '\\' . __CLASS__ . '@search')->name('Supplier.Funds.Search');
        Route::post("supplier/funds/store/{supplier}", '\\' . __CLASS__ . '@store')->name('Supplier.Funds.Store');
        Route::post("supplier/funds/delete", '\\' . __CLASS__ . '@delete')->name('Supplier.Funds.Delete');
    }

    public function store(Supplier $supplier, Request $request)
    {
        try {
            if (!$supplier) {
                throw new \Exception("Supplier Not Found.", 404);
            }

            $fund = new  SupplierFund();
            $fund->supplier_id = $supplier->id;
            $fund->payment_amount = $request->post("payment_amount");
            $fund->payment_method = $request->post("payment_method");
            $fund->date = $request->post("date");
            $fund->given_by = auth()->id();
            $fund->type = "deposit";
            $fund->message = $request->post("payment_amount") . " Tk deposited via " . $request->post("payment_method");
            $fund->saveOrFail();

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

}

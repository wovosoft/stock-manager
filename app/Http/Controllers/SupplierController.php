<?php

namespace App\Http\Controllers;

use App\Builders\Reports;
use App\Models\Supplier;
use App\Traits\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class SupplierController extends Controller
{
    protected string $model = Supplier::class;
    public array $search_selects = [
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
    ];
    public array $search_fields = [
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
    ];
    use Crud;

    public static function routes()
    {
        Route::post("suppliers/list", '\\' . __CLASS__ . '@list')->name('Suppliers.List');
        Route::post("suppliers/search", '\\' . __CLASS__ . '@search')->name('Suppliers.Search');
        Route::post("suppliers/store", '\\' . __CLASS__ . '@store')->name('Suppliers.Store');
        Route::post("suppliers/delete", '\\' . __CLASS__ . '@delete')->name('Suppliers.Delete');
    }

    public function store(Request $request)
    {
        try {
            $item = Supplier::query()->findOrNew($request->post('id'));
            $item->name = $request->post('name');
            $item->email = $request->post('email');
            $item->phone = $request->post('phone');
            $item->company = $request->post('company');
            $item->district = $request->post('district');
            $item->thana = $request->post('thana');
            $item->post_office = $request->post('post_office');
            $item->village = $request->post('village');
            $item->shipping_address = $request->post('shipping_address');
            if ($request->hasFile('photo_upload')) {
                $item->photo = $request->file('photo_upload')->store('photos', 'public');
            } else {
                $item->photo = $request->post("photo");
            }

            if (!$item) {
                throw new \Exception("Unable to Save the Data", 304);
            }
            $item->saveOrFail();
            return response()->json([
                "status" => true,
                "title" => 'SUCCESS!',
                "type" => "success",
                "msg" => ' Successfully Done',
                "item" => $item
            ]);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function list(Request $request)
    {
        try {
            $funds_deposit = "(SELECT IFNULL(SUM(supplier_funds.payment_amount),0) FROM supplier_funds WHERE supplier_funds.type='deposit' AND supplier_funds.supplier_id=suppliers.id)";
            $funds_withdrawn = "(SELECT IFNULL(SUM(supplier_funds.payment_amount),0) FROM supplier_funds WHERE supplier_funds.type='withdrawn' AND supplier_funds.supplier_id=suppliers.id)";
            $purchases_payable = "(SELECT IFNULL(SUM(purchases.payable),0) FROM purchases WHERE purchases.supplier_id = suppliers.id)";
            $purchases_paid = "(SELECT IFNULL(SUM(purchases.paid),0) FROM purchases WHERE purchases.supplier_id = suppliers.id)";
            $purchases_balance = "(SELECT IFNULL(SUM(purchases.balance),0) FROM purchases WHERE purchases.supplier_id = suppliers.id)";


            $items = Supplier::query()
                ->select([
                    "suppliers.*"
                ])
                ->selectRaw("$funds_deposit  as deposit_amount")
                ->selectRaw("$funds_withdrawn  as withdrawn_amount")
                ->selectRaw("(($funds_deposit) - ($funds_withdrawn)) as funds_balance")
                ->selectRaw("$purchases_payable  as purchases_payable")
                ->selectRaw("$purchases_paid  as purchases_paid")
                ->selectRaw("$purchases_balance  as purchases_balance")
                ->selectRaw("(($funds_deposit) - ($purchases_balance) - ($funds_withdrawn))  as final_balance");
            if ($request->has('id')) {
                return $items->findOrFail($request->post('id'));
            }
            $result = $items->defaultDatatable($request);
            $ov = $items->getQuery();
            $ov->limit = null;
            $ov->offset = null;
            $ov->orders = null;


            $ovr = $ov->select([
                DB::raw("SUM($funds_deposit) as deposit"),
                DB::raw("SUM($funds_withdrawn) as withdrawn"),
                DB::raw("SUM(($funds_deposit) - ($funds_withdrawn)) as balance"),
            ])->first();
            return response()
                ->json($result)
                ->header("fund_summery", json_encode($ovr));
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}

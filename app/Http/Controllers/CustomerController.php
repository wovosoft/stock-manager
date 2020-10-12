<?php

namespace App\Http\Controllers;

use App\Builders\Reports;
use App\Models\Customer;
use App\Models\CustomerFund;
use App\Traits\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    protected string $model = Customer::class;
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
        Route::post("customers/list", '\\' . __CLASS__ . '@list')->name('Customers.List');
        Route::post("customers/search", '\\' . __CLASS__ . '@search')->name('Customers.Search');
        Route::post("customers/store", '\\' . __CLASS__ . '@store')->name('Customers.Store');
        Route::post("customers/delete", '\\' . __CLASS__ . '@delete')->name('Customers.Delete');
        Route::post("customers/add_fund/{customer}", '\\' . __CLASS__ . '@addFund')->name('Customers.Funds.Add');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $item = Customer::query()->findOrNew($request->post('id'));
            $item->name = $request->post('name');
            $item->email = $request->post('email');
            $item->phone = $request->post('phone');
            $item->company = $request->post('company');
            $item->district = $request->post('district');
            $item->thana = $request->post('thana');
            $item->post_office = $request->post('post_office');
            $item->village = $request->post('village');
            $item->shipping_address = $request->post('shipping_address');
//            $item->balance = $request->post('balance') ?? 0;
            if ($request->hasFile('photo_upload')) {
                $item->photo = $request->file('photo_upload')->store('photos', 'public');
            } else {
                $item->photo = $request->post("photo");
            }
            if (!$item) {
                throw new \Exception("Unable to Save the Data", 304);
            }
            $item->saveOrFail();
            DB::commit();
            return response()->json([
                "status" => true,
                "title" => 'SUCCESS!',
                "type" => "success",
                "msg" => ' Successfully Done',
                "item" => $item
            ]);
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function addFund(Customer $customer, Request $request)
    {
        try {
            DB::beginTransaction();
            if (!$customer) {
                throw new \Exception("Customer Not Found.", 404);
            }

            $fund = new  CustomerFund();
            $fund->customer_id = $customer->id;
            $fund->payment_amount = $request->post("payment_amount");
            $fund->payment_method = $request->post("payment_method");
            $fund->date = $request->post("date");
            $fund->taken_by = auth()->id();
            $fund->type = "deposit";
            $fund->message = $request->post("payment_amount") . " Tk deposited via " . $request->post("payment_method");
            $fund->saveOrFail();
            DB::commit();
            return response()->json([
                "status" => true,
                "title" => 'SUCCESS!',
                "type" => "success",
                "msg" => ' Successfully Done'
            ]);
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function list(Request $request)
    {
        try {
            $funds_deposit = "(SELECT IFNULL(SUM(customer_funds.payment_amount),0) FROM customer_funds WHERE customer_funds.type='deposit' AND customer_id=customers.id)";
            $funds_withdrawn = "(SELECT IFNULL(SUM(customer_funds.payment_amount),0) FROM customer_funds WHERE customer_funds.type='withdrawn' AND customer_id=customers.id)";
            $sales_payable = "(SELECT IFNULL(SUM(sales.payable),0) FROM sales WHERE sales.customer_id = customers.id)";
            $sales_paid = "(SELECT IFNULL(SUM(sales.paid),0) FROM sales WHERE sales.customer_id = customers.id)";
            $sales_balance = "(SELECT IFNULL(SUM(sales.balance),0) FROM sales WHERE sales.customer_id = customers.id)";


            $items = Customer::query()
                ->select(["customers.*"])
                ->selectRaw("$funds_deposit  as deposit_amount")
                ->selectRaw("$funds_withdrawn  as withdrawn_amount")
                ->selectRaw("(($funds_deposit) - ($funds_withdrawn)) as funds_balance")
                ->selectRaw("$sales_payable  as sales_payable")
                ->selectRaw("$sales_paid  as sales_paid")
                ->selectRaw("$sales_balance  as sales_balance")
                ->selectRaw("(($funds_deposit) - ($sales_balance) - ($funds_withdrawn))  as final_balance");

//            throw new \Exception($items->toSql(),404);
            if ($request->has('id')) {
                return $items->findOrFail($request->post('id'));
            }
            $result = $items->defaultDatatable($request);
            $ov = $items->getQuery();
            $ov->limit = null;
            $ov->offset = null;
            $ov->orders = null;
            $ovr = $ov->select([
                DB::raw("SUM(IFNULL($funds_deposit,0)) as deposit"),
                DB::raw("SUM(IFNULL($funds_withdrawn,0))  as withdrawn"),
                DB::raw("SUM(IFNULL((($funds_deposit) - ($funds_withdrawn)),0)) as balance"),
            ])->first();
            return response()
                ->json($result)
                ->header("fund_summery", json_encode($ovr));
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}


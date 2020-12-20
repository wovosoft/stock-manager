<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\OrderCollection;
use App\Traits\Crud;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class OrderCollectionController extends Controller
{
    protected string $model = OrderCollection::class;
    public array $search_selects = ['id',];
    public array $search_fields = ['id',];
    public array $listWith;
    use Crud;

    public function __construct()
    {
        $this->listWith = [
            "user:id,name",
            "customer:id,name,phone,email",
        ];
    }

    public static function routes()
    {
        Route::name("Collections.")->prefix("collections")->group(function () {
            Route::post("list", [self::class, 'list'])->name('List');
            Route::post("search", [self::class, 'search'])->name('Search');
            Route::post("store", [self::class, 'store'])->name('Store');
            Route::post("make_payment/{customer}/{order_collection}", [self::class, 'makePayment'])->name('MakePayment');
            Route::post("delete/{order}", [self::class, 'delete'])->name('Delete');
        });
    }

    public function store(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $request->validate([
                "customer_id" => ["required", "numeric"],
                "payment_amount" => ["required", "numeric", 'min:0']
            ]);
            $customer = Customer::query()
                ->select(['id'])
                ->findOrFail($request->post('customer_id'));
            $current_balance = $customer->current_balance;

            OrderCollection::query()
                ->findOrNew($request->post('id'))
                ->forceFill([
                    "user_id" => auth()->id(),
                    "customer_id" => $request->post('customer_id'),
                    "previous_balance" => $current_balance,
                    "payment_amount" => $request->post('payment_amount'),
                    "current_balance" => $current_balance - $request->post('payment_amount'),
                    "status" => 'pending',
                    "reference" => $request->post('reference')
                ])
                ->saveOrFail();
            DB::commit();
            return successResponse();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function makePayment(Customer $customer, OrderCollection $orderCollection, Request $request)
    {
        DB::beginTransaction();
        try {
            $payment = $customer->addPayment($orderCollection->payment_amount);
            $orderCollection->payment_id = $payment->id;
            $orderCollection->saveOrFail();
            DB::commit();
            return successResponse([
                "payment_id" => $payment->id
            ]);
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function myCollections(Request $request)
    {
        $items = OrderCollection::query()
            ->where('user_id', '=', auth()->id())
            ->select([
                "order_collections.*",
                "customer_title" => function (Builder $builder) {
                    $builder
                        ->from('customers')
                        ->where("customers.id", "=", DB::raw("order_collections.customer_id"))
                        ->selectRaw("CONCAT(customers.id, ' # ', customers.name,  ' | ',customers.village)");
                }
            ])
            ->with([
                "customer"
            ]);
        if ($request->has('id') && $request->post('id')) {
            return $items->find($request->post('id'));
        }
        return $items->defaultDatatable($request);
    }

    public function delete(OrderCollection $orderCollection, Request $request)
    {
        try {
            DB::beginTransaction();
            $orderCollection->delete();
            DB::commit();
            return successResponse();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw  $exception;
        }
    }
}

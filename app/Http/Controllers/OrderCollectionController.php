<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\OrderCollection;
use App\Traits\Crud;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderCollectionController extends Controller
{
    protected string $model = OrderCollection::class;
    public array $search_selects = ['id',];
    public array $search_fields = ['id',];
    use Crud;

    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                "customer_id" => ["required", "numeric"],
                "payment_amount" => ["required", "numeric", 'min:0']
            ]);
            $customer = Customer::query()
                ->select(['id'])
                ->findOrFail($request->post('customer_id'));
            $current_balance = $customer->current_balance;
            DB::beginTransaction();
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

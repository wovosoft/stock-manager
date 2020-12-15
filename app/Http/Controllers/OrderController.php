<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Traits\Crud;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected string $model = Order::class;
    public array $search_selects = ['id',];
    public array $search_fields = ['id',];
    use Crud;

    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                "customer_id" => ["required", "numeric"],
                "items" => ["array", "required", "min:1"],
                "items.*.product_id" => ['required', 'numeric'],
                "items.*.quantity" => ['required', 'numeric'],
                "items.*.price" => ['required', 'numeric'],
            ]);
            $total = 0;
            foreach ($request->post('items') as $orderItem) {
                $total += $orderItem['price'] * $orderItem['quantity'];
            }
            DB::beginTransaction();
            $order = Order::query()
                ->findOrNew($request->post('id'))
                ->forceFill([
                    "user_id" => auth()->id(),
                    "customer_id" => $request->post('customer_id'),
                    "total" => $total,
                    "paid" => $request->post('paid') ?? 0,
                    "status" => $request->post('status') ?? "processed",
                    "note" => $request->post('note') ?? null,
                ]);
            $order->saveOrFail();
            $ids = [];
            foreach ($request->post('items') as $orderItem) {
                $oi = OrderItem::query()
                    ->findOrNew(isset($orderItem['id']) ? $orderItem['id'] : null)
                    ->forceFill([
                        "customer_id" => $request->post('customer_id'),
                        "order_id" => $order->id,
                        "product_id" => $orderItem['product_id'],
                        "quantity" => $orderItem['quantity'],
                        "price" => $orderItem['price'],
                        "total" => $orderItem['quantity'] * $orderItem['price']
                    ]);
                $oi->saveOrFail();
                $ids[] = $oi->id;
            }
            if ($request->post('id')) {
                $order->items()->whereNotIn('id', $ids)->each(function ($oi) {
                    $oi->delete();
                });
            }
            DB::commit();
            return successResponse();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function myOrders(Request $request)
    {
        $items = Order::query()
            ->where('user_id', '=', auth()->id())
            ->select([
                "orders.*",
                "customer_title" => function (Builder $builder) {
                    $builder
                        ->from('customers')
                        ->where("customers.id", "=", DB::raw("orders.customer_id"))
                        ->selectRaw("CONCAT(customers.id, ' # ', customers.name,  ' | ',customers.village)");
                }
            ])
            ->with([
                "customer",
                "items.product:id,name,code,price"
            ]);
        if ($request->has('id') && $request->post('id')) {
            return $items->find($request->post('id'));
        }
        return $items->defaultDatatable($request);
    }

    public function delete(Order $order, Request $request)
    {
        try {
            DB::beginTransaction();
            $order->delete();
            DB::commit();
            return successResponse();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw  $exception;
        }
    }

    public function deleteOrderItem(Order $order, OrderItem $orderItem, Request $request)
    {
        try {
            DB::beginTransaction();
            if ($orderItem->delete()) {
                $order->total = $order->items()->sum('total');
                $order->saveOrFail();
            }
            DB::commit();
            return successResponse([
                "order" => Order::query()
                    ->select([
                        "orders.*",
                        "customer_title" => function (Builder $builder) {
                            $builder
                                ->from('customers')
                                ->where("customers.id", "=", DB::raw("orders.customer_id"))
                                ->selectRaw("CONCAT(customers.id, ' # ', customers.name,  ' | ',customers.village)");
                        }
                    ])
                    ->with([
                        "customer",
                        "items.product:id,name,code,price"
                    ])
                    ->find($order->id)
            ]);
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw  $exception;
        }
    }
}

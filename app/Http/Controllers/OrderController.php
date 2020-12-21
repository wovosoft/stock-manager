<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Traits\Crud;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    protected string $model = Order::class;
    public array $search_selects = ['id',];
    public array $search_fields = ['id',];
    public string $date_range_by = "orders.created_at";
    use Crud;

    public static function routes()
    {
        Route::name("Orders.")->prefix("orders")->group(function () {
            Route::post("list", [self::class, 'list'])->name('List');
            Route::post("search", [self::class, 'search'])->name('Search');
            Route::post("store", [self::class, 'store'])->name('Store');
            Route::post("change_status/{order}", [self::class, 'changeStatus'])->name('ChangeStatus');
            Route::post("make_sale/{order}", [self::class, 'makeSale'])->name('MakeSale');
            Route::post("delete/{order}", [self::class, 'delete'])->name('Delete');
        });
    }

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
                    "customer_id" => $request->post('customer_id'),
                    "total" => $total,
                    "paid" => $request->post('paid') ?? 0,
                    "status" => $request->post('status') ?? "Pending",
                    "note" => $request->post('note') ?? null,
                ]);
            if (!$request->has('id')) {
                $order->user_id = auth()->id();
            }
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

    public function changeStatus(Order $order, Request $request)
    {
        try {
            $request->validate([
                "status" => [
                    "required",
                    Rule::in(['Pending', 'Accepted', 'Processed', 'Cancelled'])
                ]
            ]);
            DB::beginTransaction();
            $order->status = $request->post('status');
            $order->saveOrFail();
            DB::commit();
            return successResponse();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function makeSale(Order $order, Request $request)
    {
        DB::beginTransaction();
        try {
            $customer = Customer::query()->findOrFail($order->customer_id);
            $current_balance = $customer->current_balance;
            $sale = (new Sale())
                ->forceFill([
                    "customer_id" => $order->customer_id,
                    "tax" => 0,
                    "discount" => 0,
                    "date" => Carbon::now()->toDateString(),
                    "status" => "Processed",
                    "note" => $order->note ?? null,
                    "paid" => round($order->paid ?? 0, 2),
                    "total" => round($order->total, 2),
                    "payable" => round($order->total, 2),
                    "previous_balance" => round($current_balance, 2),
                    "current_balance" => round($current_balance + $order->total - $order->paid ?? 0, 2),
                ]);
            $sale->saveOrFail();
            if ($order->paid && ((float)$order->paid) > 0) {
                $customer->addPayment(
                    round($order->paid, 2),
                    'Cash',
                    null,
                    null,
                    null,
                    true,
                    Carbon::now()->add(CarbonInterval::milliseconds(500))->toDateTimeString()
                );
            }

            foreach ($order->items as $si) {
                $sale_item = new SaleItem();
                $sale_item->forceFill([
                    "sale_id" => $sale->id,
                    "product_id" => $si->product_id,
                    "customer_id" => $sale->customer_id,
                    "quantity" => $si->quantity,
                    "price" => round($si->price, 2),
                ]);
                $sale_item->saveOrFail();
            }
            $order->sale_id = $sale->id;
            $order->status = "Processed";
            $order->saveOrFail();
            DB::commit();
            return successResponse([
                "sale_id" => $sale->id
            ]);
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    private function getItems()
    {
        return Order::query()
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
                "user:id,name",
                "customer:id,name,phone,village,thana,district",
                "items.product:id,name,code,price"
            ]);
    }

    public function list(Request $request)
    {
        try {
            $items = $this->getItems();
            if ($request->has('id') && $request->post('id')) {
                return $items->find($request->post('id'));
            }
            return $items->defaultDatatable($request);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function myOrders(Request $request)
    {
        try {
            $items = $this
                ->getItems()
                ->where('user_id', '=', auth()->id());
            if ($request->has('id') && $request->post('id')) {
                return $items->find($request->post('id'));
            }
            return $items->defaultDatatable($request);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function delete(Order $order, Request $request)
    {
        try {
            //NOTE: apply 'gates' here. because this method is accessible from api
            DB::beginTransaction();
            $order->delete();
            DB::commit();
            return successResponse();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw  $exception;
        }
    }
//
//    public function deleteOrderItem(Order $order, OrderItem $orderItem, Request $request)
//    {
//        try {
//            DB::beginTransaction();
//            if ($orderItem->delete()) {
//                $order->total = $order->items()->sum('total');
//                $order->saveOrFail();
//            }
//            DB::commit();
//            return successResponse([
//                "order" => Order::query()
//                    ->select([
//                        "orders.*",
//                        "customer_title" => function (Builder $builder) {
//                            $builder
//                                ->from('customers')
//                                ->where("customers.id", "=", DB::raw("orders.customer_id"))
//                                ->selectRaw("CONCAT(customers.id, ' # ', customers.name,  ' | ',customers.village)");
//                        }
//                    ])
//                    ->with([
//                        "customer",
//                        "items.product:id,name,code,price"
//                    ])
//                    ->find($order->id)
//            ]);
//        } catch (\Throwable $exception) {
//            DB::rollBack();
//            throw  $exception;
//        }
//    }
}

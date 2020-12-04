<?php

namespace App\Http\Controllers;

use App\Models\SaleReturn;
use App\Traits\Crud;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class SaleReturnController extends Controller
{
    protected string $model = SaleReturn::class;
    public array $search_selects;
    public array $search_fields;
    public array $listWith;
    use Crud;

    public function __construct()
    {
        $this->listWith = [
            "customer:id,name,phone,village",
            "product:id,name,code"
        ];
        $this->search_fields = [
            'id',
            'customer_id',
            'product_id',
            'quantity',
            'amount',
            'customer_name' => function (Builder $builder) {
                $builder->from('customers')
                    ->whereNull('customers.deleted_at')
                    ->where('customers.id', '=', DB::raw('sale_returns.customer_id'))
                    ->select(['customers.name']);
            }
        ];
        $this->search_selects = [
            'id',
            'customer_id',
            'product_id',
            'quantity',
            'amount',
            'customer_name' => function (Builder $builder) {
                $builder->from('customers')
                    ->whereNull('customers.deleted_at')
                    ->where('customers.id', '=', DB::raw('sale_returns.customer_id'))
                    ->select(['customers.name']);
            }
        ];
    }

    public static function routes()
    {
        Route::name('SaleReturns.')->prefix('sale_returns')->group(function () {
            Route::post("store", [self::class, 'store'])->name('Store');
            Route::post("list", [self::class, 'list'])->name('List');
            Route::post("delete", [self::class, 'delete'])->name('Delete');
        });
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                "customer_id" => ['required', 'numeric'],
                "items" => ['required', 'array', 'min:1']
            ]);
            DB::beginTransaction();
            foreach ($request->post('items') as $sale_item):
                SaleReturn::query()
                    ->findOrNew(isset($sale_item['id']) ? $sale_item['id'] : null)
                    ->forceFill([
                        "customer_id" => $request->post('customer_id'),
                        "product_id" => $sale_item['product_id'],
                        "quantity" => $sale_item['quantity'],
                        "amount" => $sale_item['amount'],
                    ])
                    ->saveOrFail();
            endforeach;
            DB::commit();
            return successResponse();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}

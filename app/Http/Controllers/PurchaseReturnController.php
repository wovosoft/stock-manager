<?php

namespace App\Http\Controllers;

use App\Models\PurchaseReturn;
use App\Traits\Crud;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class PurchaseReturnController extends Controller
{
    protected string $model = PurchaseReturn::class;
    public array $search_selects;
    public array $search_fields;
    public string $date_range_by = "purchase_returns.created_at";
    public array $listWith;
    use Crud;

    public function __construct()
    {
        $this->listWith = [
            "supplier:id,name,phone,village",
            "product:id,name,code"
        ];
        $this->search_fields = [
            'id',
            'supplier_id',
            'product_id',
            'quantity',
            'amount',
            'supplier_name' => function (Builder $builder) {
                $builder->from('suppliers')
                    ->whereNull('suppliers.deleted_at')
                    ->where('suppliers.id', '=', DB::raw('purchase_returns.supplier_id'))
                    ->select(['suppliers.name']);
            }
        ];
        $this->search_selects = [
            'id',
            'supplier_id',
            'product_id',
            'quantity',
            'amount',
            'supplier_name' => function (Builder $builder) {
                $builder->from('suppliers')
                    ->whereNull('suppliers.deleted_at')
                    ->where('suppliers.id', '=', DB::raw('purchase_returns.supplier_id'))
                    ->select(['suppliers.name']);
            }
        ];
    }

    public static function routes()
    {
        Route::name('PurchaseReturns.')->prefix('purchase_returns')->group(function () {
            Route::post("store", [self::class, 'store'])->name('Store');
            Route::post("list", [self::class, 'list'])->name('List');
            Route::post("delete", [self::class, 'delete'])->name('Delete');
        });
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                "supplier_id" => ['required', 'numeric'],
                "items" => ['required', 'array', 'min:1']
            ]);
            DB::beginTransaction();
            foreach ($request->post('items') as $purchase_item):
                PurchaseReturn::query()
                    ->findOrNew(isset($purchase_item['id']) ? $purchase_item['id'] : null)
                    ->forceFill([
                        "supplier_id" => $request->post('supplier_id'),
                        "product_id" => $purchase_item['product_id'],
                        "quantity" => $purchase_item['quantity'],
                        "amount" => $purchase_item['amount'],
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

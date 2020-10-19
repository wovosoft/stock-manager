<?php

namespace App\Http\Controllers;

use App\Models\CapitalDeposit;
use App\Traits\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class CapitalDepositController extends Controller
{
    protected string $model = CapitalDeposit::class;
    public array $search_selects = [
        'id',
        'reference',
        'payment_amount',
        'payment_method',
        'bank',
        'check_no',
        'transaction_no',
        'created_at'
    ];
    public array $search_fields = [
        'id',
        'reference',
        'payment_amount',
        'payment_method',
        'bank',
        'check_no',
        'transaction_no',
        'created_at'
    ];
    use Crud;

    public static function routes()
    {
        Route::name('Capital.Deposits.')->prefix('capital/deposits')->group(function () {
            Route::post("list/{date?}", [static::class, 'list'])->name('List');
            Route::post("search", [static::class, 'search'])->name('Search');
            Route::post("store", [static::class, 'store'])->name('Store');
            Route::post("delete", [static::class, 'delete'])->name('Delete');
        });
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $item = CapitalDeposit::query()->findOrNew($request->post('id'));
            $item->forceFill([
                "reference" => $request->post('reference'),
                "payment_amount" => $request->post('payment_amount'),
                "payment_method" => $request->post('payment_method'),
                "bank" => $request->post('bank') ?? null,
                "check_no" => $request->post('check_no') ?? null,
                "transaction_no" => $request->post('transaction_no') ?? null,
                "deposited_by" => auth()->id(),
            ]);

            $item->saveOrFail();
            DB::commit();
            return successResponse();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function list(?string $date = null, Request $request)
    {
        try {
            $items = CapitalDeposit::query();
            if ($date) {
                $items->whereDate('created_at', '=', $date);
            }
            if ($request->has('id')) {
                if (isset($this->listWith)) {
                    return $items->findOrFail($request->post('id'));
                }
                return $items->findOrFail($request->post('id'));
            }
            if (isset($this->listWith)) {
                return $items->with($this->listWith)->defaultDatatable($request);
            }


            return response()->json($items->defaultDatatable($request))
                ->header('overview', json_encode(resetQueryForOverview($items)->select([
                    DB::raw("COUNT(id) as total_no_deposits"),
                    DB::raw("SUM(payment_amount) as total_payment_amount"),
                ])->first()));
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}

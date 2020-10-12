<?php

namespace App\Http\Controllers;

use App\Models\CapitalWithdraw;
use App\Traits\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class CapitalWithdrawController extends Controller
{
    protected string $model = CapitalWithdraw::class;
    public array $search_selects = [
        'id',
        'payment_amount',
        'payment_method',
        'bank',
        'check',
        'transaction_no',
        'created_at'
    ];
    public array $search_fields = [
        'id',
        'payment_amount',
        'payment_method',
        'bank',
        'check',
        'transaction_no',
        'created_at'
    ];
    use Crud;

    public static function routes()
    {
        Route::post("capital/withdraws/list", '\\' . __CLASS__ . '@list')->name('Capital.Withdraws.List');
        Route::post("capital/withdraws/search", '\\' . __CLASS__ . '@search')->name('Capital.Withdraws.Search');
        Route::post("capital/withdraws/store", '\\' . __CLASS__ . '@store')->name('Capital.Withdraws.Store');
        Route::post("capital/withdraws/delete", '\\' . __CLASS__ . '@delete')->name('Capital.Withdraws.Delete');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $item = CapitalWithdraw::query()->findOrNew($request->post('id'));
            $item->payment_amount = $request->post('payment_amount');
            $item->payment_method = $request->post('payment_method');
            $item->bank = $request->post('bank') ?? null;
            $item->check_no = $request->post('check_no') ?? null;
            $item->transaction_no = $request->post('transaction_no') ?? null;
            $item->withdrawn_by = auth()->id();

            if (!$item) {
                throw new \Exception("Unable to Save the Data", 304);
            }
            $item->saveOrFail();
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
            $items = CapitalWithdraw::query();
            if ($request->has('id')) {
                if (isset($this->listWith)) {
                    return $items->findOrFail($request->post('id'));
                }
                return $items->findOrFail($request->post('id'));
            }
            if (isset($this->listWith)) {
                return $items->with($this->listWith)->defaultDatatable($request);
            }


            return response()
                ->json($items->defaultDatatable($request))
                ->header("overview", json_encode(resetQueryForOverview($items)->select([
                    DB::raw("SUM(payment_amount) as total_payment_amount"),
                    DB::raw("COUNT(id) as total_no_withdrawals"),
                ])->first()));
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}

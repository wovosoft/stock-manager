<?php

namespace App\Http\Controllers;

use App\Builders\Reports;
use App\Models\CapitalDeposit;
use App\Models\CapitalWithdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class CapitalBalanceController extends Controller
{
    public static function routes()
    {
        Route::post("capital/balance", '\\' . __CLASS__ . '@balance')->name('Capital.Balance');
        Route::post("capital/fullFinancialSummery", '\\' . __CLASS__ . '@fullFinancialSummery')->name('Capital.FullFinancialSummery');
    }

    public function balance(Request $request)
    {
        try {
            $items = (new Reports())->capitalDebitCredit($request->post("search_columns"));
            $ov = $items->getQuery();
            $ov->limit = null;
            $ov->offset = null;

            $debit = $ov->sum("debit");
            $credit = $ov->sum("credit");
            return response()
                ->json(
                    $items
                        ->orderBy($request->post('orderBy') ?? 'created_at', $request->post('order') ?? 'desc')
                        ->paginate($request->post('per_page') ?? env("PER_PAGE") ?? 15)
                )
                ->header("overview", json_encode([
                    "total_deposit" => $debit,
                    "total_withdrawals" => $credit,
                    "balance" => ($debit - $credit)
                ]));
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function fullFinancialSummery()
    {
        try {
            $report = new Reports();
            return $report->summery();
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}

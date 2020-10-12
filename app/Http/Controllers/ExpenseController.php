<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Traits\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ExpenseController extends Controller
{
    protected string $model = Expense::class;
    public array $search_selects = ['id', 'name', 'description'];
    public array $search_fields = ['id', 'name', 'description'];
    public string $date_range_by = "expenses.created_at";
    use Crud;

    public static function routes()
    {
        Route::post("expenses/list", '\\' . __CLASS__ . '@list')->name('Expenses.List');
        Route::post("expenses/search", '\\' . __CLASS__ . '@search')->name('Expenses.Search');
        Route::post("expenses/store", '\\' . __CLASS__ . '@store')->name('Expenses.Store');
        Route::post("expenses/delete", '\\' . __CLASS__ . '@delete')->name('Expenses.Delete');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                "expense_category_id" => "required",
                "amount" => "required"
            ]);
            DB::beginTransaction();
            $item = Expense::query()->findOrNew($request->post('id'));
            $item->expense_category_id = $request->post('expense_category_id');
            $item->amount = $request->post('amount');
            $item->reference = $request->post('reference');
            $item->description = $request->post('description') ?? null;
            $item->taken_by = auth()->id();
            if (!$item) {
                throw new \Exception("Unable to Save the Data", 304);
            }
            $item->saveOrFail();
            DB::commit();
            return successResponse();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function list(Request $request)
    {
        try {
            $items = Expense::query();
            if ($request->has('date') && $request->post('date')) {
                $items->whereDate('expenses.created_at', '=', $request->post('date'));
            }
            $items->leftJoin("expense_categories", "expense_categories.id", "=", "expenses.expense_category_id")
                ->leftJoin("users", "users.id", "=", "expenses.taken_by")
                ->select(["expenses.*", "expense_categories.name as expense_category_name", "users.name as taken_by_name"])
                ->with(['expenseCategory']);


            if ($request->has('id')) {
                return response()
                    ->json($items->findOrFail($request->post('id')))
                    ->header("total_expense_amount", $items->sum("amount"));
            }

            return response()
                ->json($items->defaultDatatable($request, "expenses.created_at"))
                ->header("overview", json_encode(resetQueryForOverview($items)->whereNull('expenses.deleted_at')->select([
                    DB::raw("SUM(expenses.amount) as total_expense_amount"),
                    DB::raw("COUNT(expenses.id) as total_expense_quantity"),
                ])->first()));
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}

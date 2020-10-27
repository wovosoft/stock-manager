<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use App\Traits\Crud;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ExpenseCategoryController extends Controller
{
    protected string $model = ExpenseCategory::class;
    public array $search_selects = [
        'expense_categories.id',
        'expense_categories.name',
        'expense_categories.description'
    ];
    public array $search_fields = [
        'expense_categories.id',
        'expense_categories.name',
        'expense_categories.description'
    ];

    use Crud;


    public static function routes()
    {
        Route::name('Expenses.Categories.')->prefix('expense/categories')->group(function () {
            Route::post("list", [self::class, 'list'])->name('List');
            Route::post("search", [self::class, 'search'])->name('Search');
            Route::post("store", [self::class, 'store'])->name('Store');
            Route::post("delete", [self::class, 'delete'])->name('Delete');
        });
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                "name" => "required"
            ]);
            DB::beginTransaction();
            $item = ExpenseCategory::query()->findOrNew($request->post('id'));
            $item->forceFill([
                "name" => $request->post('name'),
                "description" => $request->post('description') ?? null,
            ]);
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
            $total_expense_amount = DB::table("expenses")
                ->where("expenses.expense_category_id", "=", DB::raw("expense_categories.id"))
                ->whereNull("expenses.deleted_at")
                ->selectRaw("IFNULL(SUM(expenses.amount),0)")
                ->toSql();

            $total_expense_quantity = DB::table("expenses")
                ->where("expenses.expense_category_id", "=", DB::raw("expense_categories.id"))
                ->whereNull("expenses.deleted_at")
                ->selectRaw("IFNULL(COUNT(expenses.id),0)")
                ->toSql();


            $items = ExpenseCategory::query()
                ->select([
                    "expense_categories.id",
                    "expense_categories.name",
                    DB::raw("($total_expense_amount) as total_expense_amount"),
                    DB::raw("($total_expense_quantity) as total_expense_quantity"),
                    "expense_categories.description",
                    "expense_categories.created_at",
                    "expense_categories.updated_at",
                ]);
            if ($request->has('id')) {
                return $items->findOrFail($request->post('id'));
            }
            return response()
                ->json($items->defaultDatatable($request))
//                ->header('sql', $items->toSql())
                ->header('overview', json_encode(resetQueryForOverview($items)->select([
                    DB::raw("SUM(($total_expense_amount)) as total_expense_amount"),
                    DB::raw("SUM(($total_expense_quantity)) as total_expense_quantity"),
                ])->first()));

        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}

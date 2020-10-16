<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use App\Traits\Crud;
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
        Route::name('Expenses.Categories.')->prefix('expense/categories')->group(function (){
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
            $items = ExpenseCategory::query()
                ->leftJoin("expenses", "expenses.expense_category_id", "=", "expense_categories.id")
                ->whereNull('expenses.deleted_at')
                ->groupBy("expense_categories.id")
                ->select([
                    "expense_categories.id",
                    "expense_categories.name",
                    DB::raw("IFNULL(SUM(expenses.amount),0) as total_expense_amount"),
                    DB::raw("IFNULL(COUNT(expenses.id),0) as total_expense_quantity"),
                    "expense_categories.description",
                    "expense_categories.created_at",
                    "expense_categories.updated_at",
                ]);
            if ($request->has('id')) {
                return $items->findOrFail($request->post('id'));
            }
            $result = $items->defaultDatatable($request);
            $ov = resetQueryForOverview($items)->select([
                DB::raw("IFNULL(COUNT(expense_categories.id),0) as total_expense_quantity"),
                DB::raw("IFNULL(SUM(expenses.amount),0) as total_expense_amount"),
            ])->get();

            return response()
                ->json($result)
//                ->header('sql', $items->toSql())
                ->header('overview', json_encode([
                    "total_expense_quantity" => $ov->sum("total_expense_quantity"),
                    "total_expense_amount" => $ov->sum("total_expense_amount"),
                ]));

        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}

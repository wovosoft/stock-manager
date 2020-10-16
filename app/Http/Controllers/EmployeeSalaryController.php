<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeSalary;
use App\Traits\Crud;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class EmployeeSalaryController extends Controller
{
    protected string $model = EmployeeSalary::class;
    public array $search_selects = [
        'id',
        'payment_amount',
        'payment_method',
        'date',
        'bank',
        'check',
        'transaction_no',
        'year',
        'month',
    ];
    public array $search_fields = [
        'id',
        'payment_amount',
        'payment_method',
        'date',
        'bank',
        'check',
        'transaction_no',
        'year',
        'month'
    ];
    use Crud;

    public static function routes()
    {
        Route::name('Employees.')->prefix('employees/salaries')->group(function (){
            Route::post("list", [self::class, 'list'])->name('Salaries.List');
            Route::post("search", [self::class, 'search'])->name('Salaries.Search');
            Route::post("store/{employee}", [self::class, 'store'])->name('Salaries.Store');
            Route::post("delete", [self::class, 'delete'])->name('Salaries.Delete');
        });
    }

    public function store(Employee $employee, Request $request)
    {
        try {
            $request->validate([
                "payment_amount" => "required",
                "payment_method" => "required",
                "date" => "required",
                "year" => "required|min:2018|integer",
                "month" => "required|min:1|integer"
            ]);
            DB::beginTransaction();
            $item = EmployeeSalary::query()->findOrNew($request->post('id'));
            $item->forceFill([
                "employee_id"       => $employee->id,
                "payment_amount"    => $request->post('payment_amount'),
                "payment_method"    => $request->post('payment_method'),
                "bank"              => $request->post('bank'),
                "check"             => $request->post('check'),
                "transaction_no"    => $request->post('transaction_no'),
                "date"              => $request->post('date') ?? Carbon::now()->format('Y-m-d'),
                "year"              => $request->post('year') ?? Carbon::now()->format('Y'),
                "month"             => $request->post('month') ?? Carbon::now()->format('m'),
                "given_by"          => auth()->id(),
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
            $items = EmployeeSalary::query()
                ->leftJoin("employees", function ($query) {
                    $query->on("employees.id", "=", "employee_salaries.employee_id");
                })
                ->select([
                    "employee_salaries.*",
                    "employees.name"
                ]);
            if ($request->has('date') && $request->post('date')) {
                $items->whereDate("employee_salaries.created_at", "=", $request->post("date"));
            }
            if ($request->has('id')) {
                return $items->findOrFail($request->post('id'));
            }


            return $items->defaultDatatable($request, "employee_salaries.created_at");
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}

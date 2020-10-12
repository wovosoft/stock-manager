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
        Route::post("employees/salaries/list", '\\' . __CLASS__ . '@list')->name('Employees.Salaries.List');
        Route::post("employees/salaries/search", '\\' . __CLASS__ . '@search')->name('Employees.Salaries.Search');
        Route::post("employees/salaries/store/{employee}", '\\' . __CLASS__ . '@store')->name('Employees.Salaries.Store');
        Route::post("employees/salaries/delete", '\\' . __CLASS__ . '@delete')->name('Employees.Salaries.Delete');
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

            $item->employee_id = $employee->id;
            $item->payment_amount = $request->post('payment_amount');
            $item->payment_method = $request->post('payment_method');
            $item->bank = $request->post('bank');
            $item->check = $request->post('check');
            $item->transaction_no = $request->post('transaction_no');
            $item->date = $request->post('date') ?? Carbon::now()->format('Y-m-d');
            $item->year = $request->post('year') ?? Carbon::now()->format('Y');
            $item->month = $request->post('month') ?? Carbon::now()->format('m');
            $item->given_by = auth()->id();

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

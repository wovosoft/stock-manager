<?php

namespace App\Http\Controllers;

use App\Builders\Reports;
use App\Models\Employee;
use App\Traits\Crud;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class EmployeeController extends Controller
{
    protected string $model = Employee::class;
    public array $search_selects = [
        'id',
        'name',
        'email',
        'phone',
        'company',
        'district',
        'thana',
        'post_office',
        'village',
        'joining_date',
        'leaving_date',
        'is_active',
        'position',
        'salary'
    ];
    public array $search_fields = [
        'id',
        'name',
        'email',
        'phone',
        'company',
        'district',
        'thana',
        'post_office',
        'village',
        'joining_date',
        'leaving_date',
        'is_active',
        'position',
        'salary'
    ];
    use Crud;

    public static function routes()
    {
        Route::name('Employees.')->prefix('employees')->group(function () {
            Route::post("list", [self::class, 'list'])->name('List');
            Route::post("search", [self::class, 'search'])->name('Search');
            Route::post("store", [self::class, 'store'])->name('Store');
            Route::post("delete", [self::class, 'delete'])->name('Delete');
            Route::post("{employee}/paid/salaries", [self::class, 'salaries'])->name('Paid.Salaries');
        });
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                "name" => "required",
                "position" => "required",
                "joining_date" => "required",
            ]);
            $item = Employee::query()->findOrNew($request->post('id'));
            $item->forceFill([
                "name" => $request->post('name'),
                "email" => $request->post('email'),
                "phone" => $request->post('phone'),
                "company" => $request->post('company'),
                "district" => $request->post('district'),
                "thana" => $request->post('thana'),
                "post_office" => $request->post('post_office'),
                "village" => $request->post('village'),
                "joining_date" => $request->post('joining_date'),
                "leaving_date" => $request->post('leaving_date'),
                "is_active" => !!($request->post('is_active')),
                "position" => $request->post('position'),
                "salary" => $request->post('salary') ?? 0,
            ]);
            if ($request->hasFile('photo_upload')) {
                $item->photo = $request->file('photo_upload')->store('photos', 'public');
            } else {
                $item->photo = $request->post("photo");
            }
            $item->saveOrFail();
            return successResponse();
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function list(Request $request)
    {
        try {
            $paid_salary = function (Builder $builder) {
                $builder
                    ->from('employee_salaries')
                    ->where("employee_salaries.employee_id", "=", DB::raw("employees.id"))
                    ->whereNull("employee_salaries.deleted_at")
                    ->selectRaw("IFNULL(SUM(employee_salaries.payment_amount),0)");
            };
            $items = Employee::query()
                ->select([
                    "employees.*",
                    "paid_salary" => $paid_salary
                ]);
            if ($request->has('id')) {
                return $items->findOrFail($request->post('id'));
            }

            return response()
                ->json($items->defaultDatatable($request))
                ->header("employee_summery", json_encode(resetQueryForOverview($items)->select([
                    "paid_salary" => function (Builder $builder) {
                        $builder->from('employee_salaries')
                            ->where("employee_salaries.employee_id", "=", "employees.id")
                            ->whereNull("employee_salaries.deleted_at")
                            ->selectRaw("SUM(employee_salaries.payment_amount)");
                    },
                    DB::raw("COUNT(id) as total_employees"),
                ])->first()));
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function salaries(Employee $employee, Request $request)
    {
        try {
            $items = $employee->salaries();
            if ($request->post('year')) {
                $items->where('year', '=', $request->post('year'));
            }
            return $items->defaultDatatable($request);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}

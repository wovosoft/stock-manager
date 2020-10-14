<?php

namespace App\Http\Controllers;

use App\Builders\Reports;
use App\Models\Employee;
use App\Traits\Crud;
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
        Route::post("employees/list", '\\' . __CLASS__ . '@list')->name('Employees.List');
        Route::post("employees/search", '\\' . __CLASS__ . '@search')->name('Employees.Search');
        Route::post("employees/store", '\\' . __CLASS__ . '@store')->name('Employees.Store');
        Route::post("employees/delete", '\\' . __CLASS__ . '@delete')->name('Employees.Delete');
        Route::post("employees/paid/salaries/{employee}", '\\' . __CLASS__ . '@salaries')->name('Employees.Paid.Salaries');
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
            $item->name = $request->post('name');
            $item->email = $request->post('email');
            $item->phone = $request->post('phone');
            $item->company = $request->post('company');
            $item->district = $request->post('district');
            $item->thana = $request->post('thana');
            $item->post_office = $request->post('post_office');
            $item->village = $request->post('village');
            $item->joining_date = $request->post('joining_date');
            $item->leaving_date = $request->post('leaving_date');
            $item->is_active = !!($request->post('is_active'));
            $item->position = $request->post('position');
            $item->salary = $request->post('salary') ?? 0;
//            $item->balance = $request->post('balance') ?? 0;
            if ($request->hasFile('photo_upload')) {
                $item->photo = $request->file('photo_upload')->store('photos', 'public');
            } else {
                $item->photo = $request->post("photo");
            }
            if (!$item) {
                throw new \Exception("Unable to Save the Data", 304);
            }
            $item->saveOrFail();
            return response()->json([
                "status" => true,
                "title" => 'SUCCESS!',
                "type" => "success",
                "msg" => ' Successfully Done'
            ]);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function list(Request $request)
    {
        try {
            $salary = "(SELECT IFNULL(SUM(employee_salaries.payment_amount),0) FROM employee_salaries WHERE employees.id = employee_salaries.employee_id AND employee_salaries.deleted_at IS NULL)";
            $items = Employee::query()
                ->select(["employees.*"])
                ->selectRaw("$salary AS paid_salary");
            if ($request->has('id')) {
                return $items->findOrFail($request->post('id'));
            }
            $result = $items->defaultDatatable($request);
            $ov = $items->getQuery();
            $ov->limit = null;
            $ov->offset = null;
            $ov->orders = null;
            $ovr = $ov->select([
                DB::raw("SUM($salary) as paid_salary"),
                DB::raw("COUNT(id) as total_employees"),
            ])->first();
            return response()
                ->json($result)
                ->header("employee_summery", json_encode($ovr));
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

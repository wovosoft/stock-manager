<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Traits\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class UnitController extends Controller
{
    protected string $model = Unit::class;
    public array $search_selects = ['id', 'name', 'description'];
    public array $search_fields = ['id', 'name', 'description'];
    use Crud;

    public static function routes()
    {
        Route::post("units/list", '\\' . __CLASS__ . '@list')->name('Units.List');
        Route::post("units/search", '\\' . __CLASS__ . '@search')->name('Units.Search');
        Route::post("units/store", '\\' . __CLASS__ . '@store')->name('Units.Store');
        Route::post("units/delete", '\\' . __CLASS__ . '@delete')->name('Units.Delete');
    }

    public function store(Request $request)
    {
        try {
            $item = Unit::query()->findOrNew($request->post('id'));
            $item->name = $request->post('name');
            $item->description = $request->post('description');

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
}

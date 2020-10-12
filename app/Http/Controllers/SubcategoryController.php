<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use App\Traits\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SubcategoryController extends Controller
{
    protected string $model = Subcategory::class;
    public array $search_selects = ['id', 'name', 'description'];
    public array $search_fields = ['id', 'name', 'description'];
    use Crud;

    public static function routes()
    {
        Route::post("subcategories/list", '\\' . __CLASS__ . '@list')->name('Subcategories.List');
        Route::post("subcategories/search", '\\' . __CLASS__ . '@search')->name('Subcategories.Search');
        Route::post("subcategories/store", '\\' . __CLASS__ . '@store')->name('Subcategories.Store');
        Route::post("subcategories/delete", '\\' . __CLASS__ . '@delete')->name('Subcategories.Delete');
    }

    public function store(Request $request)
    {
        try {
            $item = Subcategory::query()->findOrNew($request->post('id'));
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

<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Traits\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class BrandController extends Controller
{
    protected string $model = Brand::class;
    public array $search_selects = ['id', 'name', 'description'];
    public array $search_fields = ['id', 'name', 'description'];
    use Crud;

    public static function routes()
    {
        Route::post("brands/list", '\\' . __CLASS__ . '@list')->name('Brands.List');
        Route::post("brands/search", '\\' . __CLASS__ . '@search')->name('Brands.Search');
        Route::post("brands/store", '\\' . __CLASS__ . '@store')->name('Brands.Store');
        Route::post("brands/delete", '\\' . __CLASS__ . '@delete')->name('Brands.Delete');
    }

    public function store(Request $request)
    {
        try {
            $item = Brand::query()->findOrNew($request->post('id'));
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

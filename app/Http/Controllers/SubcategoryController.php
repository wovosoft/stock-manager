<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use App\Traits\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class SubcategoryController extends Controller
{
    protected string $model = Subcategory::class;
    public array $search_selects = ['id', 'name', 'description'];
    public array $search_fields = ['id', 'name', 'description'];
    use Crud;

    public static function routes()
    {
        Route::name('Subcategories.')->prefix('subcategories')->group(function (){
            Route::post("list", [self::class, 'list'])->name('List');
            Route::post("search", [self::class, 'search'])->name('Search');
            Route::post("store", [self::class, 'store'])->name('Store');
            Route::post("delete", [self::class, 'delete'])->name('Delete');
        });
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $item = Subcategory::query()->findOrNew($request->post('id'));
            $item->forceFill([
                "name" => $request->post('name'),
                "description" => $request->post('description'),
            ]);
            $item->saveOrFail();
            DB::commit();
            return successResponse();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}

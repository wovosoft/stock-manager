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
        Route::name("Brands.")->prefix("brands")->group(function () {
            Route::post("list", [self::class, 'list'])->name('List');
            Route::post("search", [self::class, 'search'])->name('Search');
            Route::post("store", [self::class, 'store'])->name('Store');
            Route::post("delete", [self::class, 'delete'])->name('Delete');
        });
    }

    public function store(Request $request)
    {
        try {
            $item = Brand::query()->findOrNew($request->post('id'));
            $item->forceFill([
                "name" => $request->post('name'),
                "description" => $request->post('description'),
            ]);

            $item->saveOrFail();
            return successResponse();
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}

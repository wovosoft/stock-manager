<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Traits\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class UnitController extends Controller
{
    protected string $model = Unit::class;
    public array $search_selects = ['id', 'name', 'description'];
    public array $search_fields = ['id', 'name', 'description'];
    use Crud;

    public static function routes()
    {
        Route::name("Units.")->prefix("units")->group(function () {
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
            Unit::query()
                ->findOrNew($request->post('id'))
                ->forceFill([
                    "name" => $request->post('name'),
                    "description" => $request->post('description'),
                ])
                ->saveOrFail();
            DB::commit();
            return successResponse();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}

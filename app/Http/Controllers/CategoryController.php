<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use App\Traits\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class CategoryController extends Controller
{
    protected string $model = Category::class;
    public array $search_selects = ['id', 'name', 'code', 'description'];
    public array $search_fields = ['id', 'name', 'code', 'description'];
    public array $listWith = ['subcategories'];
    public array $searchWith = ['subcategories:id,category_id,name'];
    use Crud;

    public static function routes()
    {
        Route::name("Categories.")->prefix("categories")->group(function () {
            Route::post("list", [self::class, 'list'])->name('List');
            Route::post("search", [self::class, 'search'])->name('Search');
            Route::post("store", [self::class, 'store'])->name('Store');
            Route::post("delete", [self::class, 'delete'])->name('Delete');
        });
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                "name" => "required"
            ]);
            DB::beginTransaction();

            $item = Category::query()->findOrNew($request->post('id'));
            $item->forceFill([
                "name" => $request->post('name'),
                "code" => $request->post('code'),
                "description" => $request->post('description'),
            ]);

            $item->saveOrFail();
            $subcatids = [];
            if ($request->post("subcategories") && is_array($request->post("subcategories"))) {
                foreach ($request->post("subcategories") as $subcategory) {
                    if (isset($subcategory['id'])) {
                        $subcat = Subcategory::query()->findOrFail($subcategory['id']);
                    } else {
                        $subcat = new Subcategory();
                    }

                    $subcat->category_id = $item->id;
                    $subcat->name = $subcategory['name'];
                    $subcat->description = isset($subcategory['description']) ? $subcategory['description'] : null;
                    $subcat->saveOrFail();
                    $subcatids[] = $subcat->id;
                }
            }

            $item->subcategories->each(function ($subcat) use ($subcatids) {
                if (!in_array($subcat->id, $subcatids)) {
                    $subcat->delete();
                }
            });
            DB::commit();
            return successResponse();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}

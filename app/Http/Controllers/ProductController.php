<?php

namespace App\Http\Controllers;

use App\Builders\Reports;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use App\Traits\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ProductController extends Controller
{
    protected string $model = Product::class;
    public array $search_selects = [
        'id',
        'name',
        'code',
        'price',
        'quantity',
        'description'
    ];
    public array $search_fields = [
        'id',
        'name',
        'code',
        'price',
        'quantity',
        'description'
    ];
    public string $date_range_by = "products.created_at";
    use Crud;

    public static function routes()
    {
        Route::post("products/list", '\\' . __CLASS__ . '@list')->name('Products.List');
        Route::post("products/search", '\\' . __CLASS__ . '@search')->name('Products.Search');
        Route::post("products/store", '\\' . __CLASS__ . '@store')->name('Products.Store');
        Route::post("products/delete", '\\' . __CLASS__ . '@delete')->name('Products.Delete');
        Route::post("products/get/categories_units", '\\' . __CLASS__ . '@categoryAndUnits')->name('Products.Get.Category.Unit');
        Route::post("products/pst/items", '\\' . __CLASS__ . '@getPosProducts')->name('Products.POS.Items');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $item = Product::query()->findOrNew($request->post('id'));
            $item->name = $request->post('name');
            $item->barcode_symbology = $request->post('barcode_symbology') ?? 'code128';
            $item->code = $request->post('code') ?? 'code128';
            $item->cost = $request->post('cost') ?? 0;
            $item->price = $request->post('price') ?? 0;
            $item->category_id = $request->post('category_id');
            $item->subcategory_id = $request->post('subcategory_id');
            $item->brand_id = $request->post('brand_id');
            $item->status = $request->post('status') ?? true;
            $item->unit_id = $request->post('unit_id');
            $item->quantity = $request->post('quantity') ?? 0;
            $item->alert_quantity = $request->post('alert_quantity') ?? 0;
            $item->description = $request->post('description');

            if ($request->hasFile('photo_upload')) {
                $item->photo = $request->file('photo_upload')->store('products', 'public');
            } else {
                $item->photo = $request->post('photo');
            }


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

    public function categoryAndUnits()
    {
        return response()->json([
            "categories" => Category::query()->select([
                DB::raw('id as value'),
                DB::raw('name as text')
            ])->get(),
            "units" => Unit::query()->select([
                DB::raw('id as value'),
                DB::raw('name as text')
            ])->get()
        ]);
    }

    public function list(Request $request)
    {
        try {
            $items = Product::query()
                ->select([
                    "products.*",
                    DB::raw("brands.name as brand_name"),
                    DB::raw("categories.name as category_name"),
                    DB::raw("subcategories.name as subcategory_name"),
                    DB::raw("units.name as unit_name"),
                    DB::raw("(products.quantity * products.cost) as total_cost"),
                    DB::raw("(products.quantity * products.price) as total_price"),
                    DB::raw("((products.quantity * products.price) - (products.quantity * products.cost)) as probable_profit"),
                ])
                ->leftJoin("brands", "brands.id", "=", "products.brand_id")
                ->leftJoin("categories", "categories.id", "=", "products.category_id")
                ->leftJoin("subcategories", "subcategories.id", "=", "products.subcategory_id")
                ->leftJoin("units", "units.id", "=", "products.unit_id")
                ->with(['unit:id,name', 'category:id,name', 'category.subcategories:id,category_id,name', 'brand:id,name']);

            if ($request->has('id')) {
                return $items->find($request->post('id'));
            }

            return response()
                ->json($items->defaultDatatable($request, "products.created_at"))
                ->header('overview', json_encode(resetQueryForOverview($items)->select([
                    DB::raw("SUM(products.quantity * products.cost) as cost"),
                    DB::raw("SUM(products.quantity * products.price) as price"),
                    DB::raw("SUM((products.quantity * products.price) - (products.quantity * products.cost)) as balance"),
                ])->first()));
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }

    public function getPosProducts(Request $request)
    {
        try {
            $items = Product::query()
                ->select([
                    "id",
                    "name",
                    "code",
                    "category_id",
                    "subcategory_id",
                    "price",
                    "quantity",
                    "photo"
                ]);
            if ($request->has("category_id") && $request->post("category_id")) {
                $items->where("category_id", "=", $request->post("category_id"));
            }
            return $items->paginate($request->post("per_page") ?? 15);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Builders\Reports;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use App\Traits\Crud;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ProductController extends Controller
{
    protected string $model = Product::class;
    public array $search_selects;
    public array $search_fields;
    public string $date_range_by = "products.created_at";
    private $purchase_item, $sale_item, $return_item, $quantity_sql;
    use Crud;

    public function __construct()
    {
        $this->purchase_item = DB::table('purchase_items')
            ->whereNull('purchase_items.deleted_at')
            ->where('purchase_items.product_id', '=', DB::raw('products.id'))
            ->selectRaw("IFNULL(SUM(purchase_items.quantity),0)")
            ->toSql();

        $this->sale_item = DB::table('sale_items')
            ->whereNull('sale_items.deleted_at')
            ->where('sale_items.product_id', '=', DB::raw('products.id'))
            ->selectRaw("IFNULL(SUM(sale_items.quantity),0)")
            ->toSql();

        $this->sale_returned = DB::table('sale_returns')
            ->whereNull('sale_returns.deleted_at')
            ->where('sale_returns.product_id', '=', DB::raw('products.id'))
            ->selectRaw("IFNULL(SUM(sale_returns.quantity),0)")
            ->toSql();

        $this->quantity_sql = "(($this->purchase_item) - ($this->sale_item) + ($this->sale_returned))";
        $this->search_selects = [
            'id',
            'name',
            'code',
            'cost',
            'price',
            'description',
            'quantity' => function (Builder $builder) {
                $builder->selectRaw($this->quantity_sql);
            }
        ];
        $this->search_fields = [
            'id',
            'name',
            'code',
            'cost',
            'price',
            'description',
            'quantity' => function (Builder $builder) {
                $builder->selectRaw($this->quantity_sql);
            }
        ];
    }

    public static function routes()
    {
        Route::name("Products.")->prefix("products")->group(function () {
            Route::post("list", [self::class, 'list'])->name('List');
            Route::post("search", [self::class, 'search'])->name('Search');
            Route::post("store", [self::class, 'store'])->name('Store');
            Route::post("delete", [self::class, 'delete'])->name('Delete');
            Route::post("get/categories_units", [self::class, 'categoryAndUnits'])->name('Get.Category.Unit');
            Route::post("pos/items", [self::class, 'getPosProducts'])->name('POS.Items');
        });
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $item = Product::query()->findOrNew($request->post('id'));

            $item->forceFill([
                "name" => $request->post('name'),
                "barcode_symbology" => $request->post('barcode_symbology') ?? 'code128',
                "code" => $request->post('code') ?? 'code128',
                "cost" => $request->post('cost') ?? 0,
                "price" => $request->post('price') ?? 0,
                "category_id" => $request->post('category_id'),
                "subcategory_id" => $request->post('subcategory_id'),
                "brand_id" => $request->post('brand_id'),
                "status" => $request->post('status') ?? true,
                "unit_id" => $request->post('unit_id'),
                "alert_quantity" => $request->post('alert_quantity') ?? 0,
                "description" => $request->post('description')
            ]);

            if ($request->hasFile('photo_upload')) {
                $item->photo = $request->file('photo_upload')->store('products', 'public');
            } else {
                $item->photo = $request->post('photo');
            }
            $item->saveOrFail();
            DB::commit();
            return successResponse();
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
                    'quantity' => function (Builder $builder) {
                        $builder->selectRaw($this->quantity_sql);
                    },
                    DB::raw("brands.name as brand_name"),
                    DB::raw("categories.name as category_name"),
                    DB::raw("subcategories.name as subcategory_name"),
                    DB::raw("units.name as unit_name"),
                    DB::raw("($this->quantity_sql * products.cost) as total_cost"),
                    DB::raw("($this->quantity_sql * products.price) as total_price"),
                    DB::raw("(($this->quantity_sql * products.price) - ($this->quantity_sql * products.cost)) as probable_profit"),
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
                    DB::raw("SUM(($this->quantity_sql) * products.cost) as cost"),
                    DB::raw("SUM(($this->quantity_sql) * products.price) as price"),
                    DB::raw("SUM(($this->quantity_sql) * (products.price - products.cost)) as balance"),
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
                    "cost",
                    'quantity' => function (Builder $builder) {
                        $builder->selectRaw($this->quantity_sql);
                    },
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

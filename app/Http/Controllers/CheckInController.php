<?php

namespace App\Http\Controllers;

use App\Models\CheckIn;
use App\Models\CheckInItem;
use App\Models\Product;
use App\Traits\Crud;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class CheckInController extends Controller
{
    protected string $model = CheckIn::class;
    public array $search_selects = ['id', 'datetime', 'reference', 'note'];
    public array $search_fields = ['id', 'datetime', 'reference', 'note'];
    use Crud;

    public static function routes()
    {
        Route::post("check_in/list", '\\' . __CLASS__ . '@list')->name('Check.Ins.List');
        Route::post("check_in/search", '\\' . __CLASS__ . '@search')->name('Check.Ins.Search');
        Route::post("check_in/store", '\\' . __CLASS__ . '@store')->name('Check.Ins.Store');
        Route::post("check_in/delete", '\\' . __CLASS__ . '@delete')->name('Check.Ins.Delete');
    }

    public function store(Request $request)
    {
        try {
            $item = CheckIn::query()->findOrNew($request->post('id'));
            $item->created_by = auth()->id();
            $item->datetime = $request->post('datetime') ?? Carbon::now();
            $item->reference = $request->post('reference');
            $item->supplier_id = $request->post('supplier_id');
            if ($request->hasFile('attachment_upload')) {
                $item->attachment = $request->file('attachment_upload')->store('check_ins', 'public');
            } else {
                $item->attachment = $request->post('attachment');
            }
            $item->note = $request->post('note');

            if (!$item) {
                throw new \Exception("Unable to Save the Data", 304);
            }
            $item->saveOrFail();
            $ids = [];
            if ($request->has('items') && is_array($request->post('items'))) {
                foreach ($request->post('items') as $citem) {
                    if (isset($citem['id'])) {
                        $ci = CheckInItem::query()->findOrFail($citem['id']);
                    } else {
                        $ci = new CheckInItem;
                    }

                    $ci->check_in_id = $item->id;
                    $ci->product_id = $citem['product_id'];
                    $ci->quantity = $citem['quantity'];
                    $ci->saveOrFail();

                    $ids[] = $ci->id;
                }
            }
            $item->items()->whereNotIn('id', $ids)->each(function ($it) {
                $it->delete();
            });

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
            $items = CheckIn::with([
                'supplier:id,name',
                'creator:id,name,email',
                'items' => function ($q) {
                    $q->leftJoin('products', 'products.id', '=', 'check_in_items.product_id')
                        ->select([
                            'check_in_items.*',
                            'products.name',
                            'products.code',
                            DB::raw('products.quantity as available')
                        ]);
                }
            ]);
            if ($request->has('id')) {
                return $items->find($request->post('id'));
            }
            return $items->defaultDatatable($request);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}

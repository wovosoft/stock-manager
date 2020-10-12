<?php

namespace App\Http\Controllers;

use App\Models\CheckOut;
use App\Models\CheckOutItem;
use App\Traits\Crud;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class CheckOutController extends Controller
{
    protected string $model = CheckOut::class;
    public array $search_selects = ['id', 'datetime', 'reference', 'note'];
    public array $search_fields = ['id', 'datetime', 'reference', 'note'];
    use Crud;

    public static function routes()
    {
        Route::post("check_out/list", '\\' . __CLASS__ . '@list')->name('Check.Outs.List');
        Route::post("check_out/search", '\\' . __CLASS__ . '@search')->name('Check.Outs.Search');
        Route::post("check_out/store", '\\' . __CLASS__ . '@store')->name('Check.Outs.Store');
        Route::post("check_out/delete", '\\' . __CLASS__ . '@delete')->name('Check.Outs.Delete');
    }

    public function store(Request $request)
    {
        try {
            $item = CheckOut::query()->findOrNew($request->post('id'));
            $item->created_by = auth()->id();
            $item->datetime = $request->post('datetime') ?? Carbon::now();
            $item->reference = $request->post('reference');
            $item->supplier_id = $request->post('supplier_id');
            if ($request->hasFile('attachment_upload')) {
                $item->attachment = $request->file('attachment_upload')->store('check_outs', 'public');
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
                        $ci = CheckOutItem::query()->findOrFail($citem['id']);
                    } else {
                        $ci = new CheckOutItem();
                    }

                    $ci->check_out_id = $item->id;
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
            $items = CheckOut::with([
                'supplier:id,name',
                'creator:id,name,email',
                'items' => function ($q) {
                    $q->leftJoin('products', 'products.id', '=', 'check_out_items.product_id')
                        ->select([
                            'check_out_items.*',
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

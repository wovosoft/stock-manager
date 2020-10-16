<?php

namespace App\Http\Controllers;

use App\Models\Sms;
use App\Traits\Crud;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class SmsController extends Controller
{
    protected string $model = Sms::class;
    public array $search_selects = ['id','type','sender','message','contacts','delivery'];
    public array $search_fields = ['id','type','sender','message','contacts','delivery'];
    use Crud;

    public static function routes()
    {
        Route::name('SMS.')->prefix('sms')->group(function (){
            Route::post("store", [static::class, 'store'])->name('Store');
            Route::post("list", [static::class, 'list'])->name('List');
            Route::post("search", [static::class, 'search'])->name('Search');
            Route::post("delete", [static::class, 'delete'])->name('Delete');
        });
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                "contacts" => ["required"],
                "message" => ["required"],
            ]);
            DB::beginTransaction();
            $sms = Sms::query()->findOrNew($request->post('id'));
            $sms->forceFill([
                "provider" => "MIMSMS",
                "sms_id" => null,
                "type" => $request->post("type") ?? "text",
                "sender" => env("MIMSMS_SENDERID"),
                "contacts" => $request->post("contacts"),
                "message" => $request->post("message"),
                "delivery" => "created",
            ]);
            $sms->saveOrFail();
            if ($request->post('resend') || !$request->has('id')) {
                $sms->send();
            }
            DB::commit();
            return successResponse();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

}

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
    public array $search_selects = ['id',];
    public array $search_fields = ['id',];
    use Crud;

    public static function routes()
    {
        Route::post("sms/store", [static::class, 'store'])->name('SMS.Store');
        Route::post("sms/list", [static::class, 'list'])->name('SMS.List');
        Route::post("sms/search", [static::class, 'search'])->name('SMS.Search');
        Route::post("sms/delete", [static::class, 'delete'])->name('SMS.Delete');
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
            $sms->provider = "MIMSMS";
            $sms->sms_id = null;
            $sms->type = $request->post("type") ?? "text";
            $sms->sender = env("MIMSMS_SENDERID");
            $sms->contacts = $request->post("contacts");
            $sms->message = $request->post("message");
            $sms->delivery = "created";
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

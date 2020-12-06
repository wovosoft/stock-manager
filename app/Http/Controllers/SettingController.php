<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class SettingController extends Controller
{
    public static function routes()
    {
        Route::post("settings/store", '\\' . __CLASS__ . '@store')->name('Settings.Store');
        Route::post("settings/list", '\\' . __CLASS__ . '@list')->name('Settings.List');
        Route::post("settings/setCurrentLanguage", '\\' . __CLASS__ . '@setCurrentLanguage')->name('Settings.setCurrentLanguage');
    }

    public function store(Request $request)
    {
        try {
            foreach ($request->post() as $key => $value) {
                if (!in_array($key, ['logo'])) {
                    $item = Setting::query()->where('key', $key)->firstOrFail();
                    $item->value = $value;
                    $item->saveOrFail();
                }
            }
            \Artisan::call("env:set", [
                "key" => "TIMEZONE",
                "value" => '"' . $request->post('timezone') . '"' ?? '"Asia/Dhaka"'
            ]);
            //Artisan::call("config:cache");

            if ($request->hasFile('logo_upload')) {
                $logo = Setting::query()->where('key', 'logo')->firstOrFail();
                $logo->value = $request->file('logo_upload')->store('photos', 'public');
                $logo->saveOrFail();
            }
            refreshCachedSettings();
            return successResponse();
        } catch (\Throwable $exception) {
            throw  $exception;
        }
    }

    public function list(Request $request)
    {
        try {
            return Setting::query()
                ->select(['id', 'key', 'value'])
                ->orderBy('key', 'ASC')
                ->get();
        } catch (\Throwable $exception) {
            throw  $exception;
        }
    }

    public function setCurrentLanguage(Request $request)
    {
        try {
            $request->validate([
                "language_id" => "required"
            ]);
            DB::beginTransaction();
            $language_setting = Setting::query()->where('key', 'language')->firstOrFail();
            $language_setting->value = $request->post("language_id") ?? 1;
            $language_setting->saveOrFail();
            DB::commit();
            refreshCachedSettings();
            return successResponse();
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw  $exception;
        }
    }
}

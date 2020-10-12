<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
                if ($key !== 'logo') {
                    $item = Setting::query()->where('key', $key)->firstOrFail();
                    $item->value = $value;
                    $item->saveOrFail();
                }
            }
            if ($request->hasFile('logo_upload')) {
                $logo = Setting::query()->where('key', 'logo')->firstOrFail();
                $logo->value = $request->file('logo_upload')->store('photos', 'public');
                $logo->saveOrFail();
            }
            refreshCachedSettings();
            return response()->json([
                "status" => true,
                "title" => 'SUCCESS!',
                "type" => "success",
                "msg" => ' Successfully Done'
            ]);
        } catch (\Throwable $exception) {
            throw  $exception;
        }
    }

    public function list(Request $request)
    {
        try {
            return Setting::query()->select(['id', 'key', 'value'])->orderBy('key', 'ASC')->get();
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
            $language_setting = Setting::query()->where('key', 'language')->firstOrFail();
            $language_setting->value = $request->post("language_id") ?? 1;
            $language_setting->saveOrFail();
            refreshCachedSettings();
            return response()->json([
                "status" => true,
                "title" => 'SUCCESS!',
                "type" => "success",
                "msg" => ' Successfully Done'
            ]);
        } catch (\Throwable $exception) {
            throw  $exception;
        }
    }
}

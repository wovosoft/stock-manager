<?php

use App\Models\Language;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

if (!function_exists('bInitData')) {
    /**
     * @param string $url
     * @param string $rid
     * @return string
     */
    function bInitData(string $url = null, string $rid = null): string
    {
        if (!$url) $url = url()->current();
        if (!$rid) $rid = uniqid();

        return "{url:'$url',rid:'$rid'}";
    }
}


if (!function_exists('isActiveRoute')) {
    /**
     * Used to apply active class to the frontend views
     * @param string $name
     * @param string | array $class String or One Dimensional String Array
     * @return string
     */
    function isActiveRoute(string $name, $class = 'active')
    {
        return request()->route()->getName() === $name ? (is_array($class) ? join(' ', $class) : $class) : '';
    }
}
if (!function_exists('_t')) {
    function _t($key, $default = null, $lang_id = 1)
    {
        return \Illuminate\Support\Facades\Config::get("lang_{$lang_id}_$key", $default ?? $key);
    }
}

if (!function_exists("_s")) {
    function _s($key, $default = null)
    {
        $settings = \Illuminate\Support\Facades\Config::get("the_settings");
        if ($settings) {
            return isset($settings[$key]) ? $settings[$key] : $default;
        }
        return $default;
    }
}

if (!function_exists('forgetCachedSettings')) {
    function forgetCachedSettings()
    {
        return Cache::forget("the_settings");
    }
}

if (!function_exists('rememberSettingsInCache')) {
    function rememberSettingsInCache()
    {
        return Cache::put("the_settings", Setting::query()->select(["key", "value"])->get());
    }
}

if (!function_exists('refreshCachedSettings')) {
    function refreshCachedSettings()
    {
        forgetCachedSettings();
        rememberSettingsInCache();
    }
}

if (!function_exists('getCachedSettings')) {
    function getCachedSettings()
    {
        return Cache::get("the_settings", fn() => Setting::query()->select(["key", "value"])->get());
    }
}

if (!function_exists('loadCachedSettingsInConfig')) {
    function loadCachedSettingsInConfig()
    {
        Config::set("the_settings", getCachedSettings()->pluck('value', 'key'));
    }
}


if (!function_exists('currentLangTranslations')) {
    function currentLangTranslations()
    {
        return config()->get("lang_" . _s("language"));
    }
}

if (!function_exists('getCachedLanguage')) {
    function getCachedLanguage()
    {
        return Cache::get("the_translations", fn() => Language::query()->select(['id', 'name'])->with(['definitions'])->get());
    }
}
if (!function_exists('loadLanguagesInConfig')) {
    function loadLanguagesInConfig()
    {
        getCachedLanguage()->each(function ($lang) {
            foreach ($lang->definitions as $definition) {
                Config::set("lang_{$lang->id}_{$definition->key}", $definition->value);
            }
            Config::set("lang_{$lang->id}", $lang->definitions->pluck('value', 'key'));
        });
    }
}

if (!function_exists('forgetLanguages')) {
    function forgetLanguages()
    {
        return Cache::forget('the_translations');
    }
}

if (!function_exists('rememberLanguages')) {
    function rememberLanguages()
    {
        return Cache::put('the_translations', Language::query()->select(['id', 'name'])->with(['definitions'])->get());
    }
}
if (!function_exists('refreshLanguages')) {
    function refreshLanguages()
    {
        forgetLanguages();
        rememberLanguages();
    }
}

if (!function_exists('storeFile')) {
    /**
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $path
     * @param string $directory
     * @return mixed
     */
    function storeFile($file, $path = "/", $directory = "public")
    {
        return $file->store($path, $directory);
    }
}

if (!function_exists("successResponse")) {
    function successResponse(array $options = [])
    {
        return response()->json(array_merge([
            "status" => true,
            "title" => 'SUCCESS!',
            "type" => "success",
            "msg" => ' Successfully Done'
        ], $options));
    }
}
if (!function_exists("failedResponse")) {
    function failedResponse(array $options = [])
    {
        return response()->json(array_merge([
            "status" => false,
            "title" => 'FAILED!',
            "type" => "danger",
            "msg" => 'Operation Failed'
        ], $options));
    }
}
if (!function_exists("failedResponseWithException")) {
    function failedResponseWithException(Throwable $exception, array $options = [])
    {
        $main = [
            "status" => false,
            "title" => 'FAILED!',
            "type" => "danger",
            "msg" => 'Operation Failed'
        ];
        if (app()->environment() !== "production") {
            $main = array_merge($main, [
                "msg" => $exception->getMessage(),
                "code" => $exception->getCode(),
                "file" => $exception->getFile(),
                "line" => $exception->getLine()
            ]);
        }
        return response()->json(array_merge($main, $options));
    }
}
if (!function_exists('resetQueryForOverview')) {
    function resetQueryForOverview(\Illuminate\Database\Eloquent\Builder $query, array $options = ['limit' => null, 'offset' => null, 'orders' => null])
    {
        $ov = $query->getQuery();
        foreach ($options as $key => $value) {
            $ov->$key = $value;
        }
        return $ov;
    }
}
if (!function_exists('updateOrGenerateProductRecords')) {
    function updateOrGenerateProductRecords($product_id)
    {
        $file = 'product_records/' . Carbon::now()->format('Y_m_d') . ".json";
        if (!\Illuminate\Support\Facades\Storage::exists($file)) {
            \Illuminate\Support\Facades\Artisan::call("record:products");
        } else {
            $data = json_decode(\Illuminate\Support\Facades\Storage::get($file));
            $index = 0;
            \Illuminate\Support\Arr::first($data, function ($value, $key) use ($product_id) {
                return $value->id === $product_id;
            });
            foreach ($data as $d) {
                if ($d->id === $product_id) {
                    break;
                }
                ++$index;
            }
            if ($index > -1) {
                $data[$index] = \App\Models\Product::query()->select(['id', 'quantity', 'cost', 'price'])->findOrFail($product_id);
            }
            \Illuminate\Support\Facades\Storage::put($file, json_encode($data));
        }
    }
}

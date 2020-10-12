<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Traits\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

class LanguageController extends Controller
{
    protected string $model = Language::class;
    public array $search_selects = [
        'id',
        'name',
        'description',
    ];
    public array $search_fields = [
        'id',
        'name',
        'description',
    ];
    public array $listWith = ['definitions'];
    use Crud;

    public static function routes()
    {
        Route::post("languages/list", '\\' . __CLASS__ . '@list')->name('Languages.List');
        Route::post("languages/search", '\\' . __CLASS__ . '@search')->name('Languages.Search');
        Route::post("languages/store", '\\' . __CLASS__ . '@store')->name('Languages.Store');
        Route::post("languages/delete", '\\' . __CLASS__ . '@delete')->name('Languages.Delete');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                "name" => ["required", "min:2"],
                "definitions" => ["required", "array"]
            ]);
            $item = Language::query()->findOrNew($request->post('id'));
            $item->name = $request->post('name');
            $item->description = $request->post("description");
            if ($request->hasFile('photo_upload')) {
                $item->photo = $request->file('photo_upload')->store('photos', 'public');
            } else {
                $item->photo = $request->post("photo");
            }
            if (!$item) {
                throw new \Exception("Unable to Save the Data", 304);
            }

            if (!($request->has("definitions") && is_array($request->post("definitions")))) {
                throw new \Exception("Definitions Not Provided");
            }
            $item->saveOrFail();

            foreach ($request->post("definitions") as $definition) {
                if (isset($definition['key'])) {
                    $def = $item->definitions()->firstOrNew([
                        'key' => $definition['key']
                    ]);
                    $def->value = $definition['value'];
                    $def->saveOrFail();
                }
            }

            refreshLanguages();

            return successResponse();
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}

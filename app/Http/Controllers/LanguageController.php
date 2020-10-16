<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Traits\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
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
        Route::name('Languages.')->prefix('languages')->group(function (){
            Route::post("list", [self::class, 'list'])->name('List');
            Route::post("search", [self::class, 'search'])->name('Search');
            Route::post("store", [self::class, 'store'])->name('Store');
            Route::post("delete", [self::class, 'delete'])->name('Delete');
        });
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                "name" => ["required", "min:2"],
                "definitions" => ["required", "array"]
            ]);
            DB::beginTransaction();
            $item = Language::query()->findOrNew($request->post('id'));
            $item->forceFill([
                "name" => $request->post('name'),
                "description" => $request->post("description"),
            ]);
            if ($request->hasFile('photo_upload')) {
                $item->photo = $request->file('photo_upload')->store('photos', 'public');
            } else {
                $item->photo = $request->post("photo");
            }
            if (!($request->has("definitions") && is_array($request->post("definitions")))) {
                throw new \Exception("Definitions Not Provided");
            }
            $item->saveOrFail();
            DB::commit();
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
            DB::rollBack();
            throw $exception;
        }
    }
}

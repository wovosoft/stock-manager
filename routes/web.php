<?php

use App\User;
use Illuminate\Http\Request;
use \App\Http\Controllers as CC;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Validation\ValidationException;

Auth::routes(["register" => false]);

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
    return $user->createToken($request->device_name)->plainTextToken;
});


Route::pattern('url', '.*');

Route::middleware(['auth'])->prefix('backend')->name('Backend.')->group(function () {
    CC\CategoryController::routes();
    CC\SupplierController::routes();
    CC\CustomerController::routes();
    CC\EmployeeController::routes();
    CC\EmployeeSalaryController::routes();
    CC\BrandController::routes();
    CC\UnitController::routes();
    // CC\SubcategoryController::routes();
    CC\ProductController::routes();
    CC\HistoryController::routes();
    //CC\WidgetsController::routes();
    CC\SettingController::routes();
    CC\SaleController::routes();
    CC\SaleItemController::routes();
    CC\OrderController::routes();
    CC\OrderCollectionController::routes();

    CC\PurchaseController::routes();
    CC\PurchasePaymentController::routes();
    CC\PurchaseItemController::routes();
    CC\CustomerBalanceController::routes();
    CC\SupplierBalanceController::routes();
    CC\SalePaymentController::routes();
    CC\LanguageController::routes();
    CC\CapitalDepositController::routes();
    CC\CapitalWithdrawController::routes();
    CC\CapitalBalanceController::routes();
    CC\ExpenseCategoryController::routes();
    CC\ExpenseController::routes();
    CC\SmsController::routes();
    CC\TransactionController::routes();
    CC\ReportsController::routes();
    CC\SaleReturnController::routes();
    CC\PurchaseReturnController::routes();

});
Route::get('routes', function () {
    Artisan::call('route:list');
    return response()->json(Artisan::output());
});
Route::middleware(['auth'])->group(function () {
    Route::get('/{url?}', function () {
        //        if (app()->environment('production')) {
        //            $tt = currentLangTranslations();
        //        } else {
        //            $local_trans = json_decode(\Illuminate\Support\Facades\File::get(resource_path("lang/full.json")));
        //            $tt = [];
        //            foreach ($local_trans as $key => $value) {
        //                $tt[$key] = $value->bn;
        //            }
        //        }
        return view('layouts.dashboard', [
            "list_languages" => \App\Models\Language::query()
                ->select(['id', 'name'])
                ->get()
                ->pluck('id', 'name'),
            "translations" => currentLangTranslations()
        ]);
    })->name('Admin');
});

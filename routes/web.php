<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers as CC;
use Illuminate\Http\Request;
Auth::routes(["register" => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/access-token', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        // Authentication passed...
        $user = Auth::user();
        $token = $user->createToken('Token Name')->accessToken;

        return response()->json($token);
    }
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
    CC\SubcategoryController::routes();
    CC\ProductController::routes();
    CC\HistoryController::routes();
    CC\WidgetsController::routes();
    CC\SettingController::routes();
    CC\SaleController::routes();
    CC\SaleItemController::routes();
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
});
Route::middleware(['auth'])->group(function () {
    Route::get('/{url?}', fn() => view('layouts.dashboard', [
        "list_languages" => \App\Models\Language::query()->select(['id', 'name'])->get()->pluck('id', 'name')
    ]))->name('Admin');
});


<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(["register" => false]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get("/test", fn() => view("test"));
Route::pattern('url', '.*');

Route::middleware(['auth'])->prefix('backend')->name('Backend.')->group(function () {
    \App\Http\Controllers\CategoryController::routes();
    \App\Http\Controllers\SupplierController::routes();
    \App\Http\Controllers\CustomerController::routes();
    \App\Http\Controllers\EmployeeController::routes();
    \App\Http\Controllers\EmployeeSalaryController::routes();
    \App\Http\Controllers\BrandController::routes();
    \App\Http\Controllers\UnitController::routes();
    \App\Http\Controllers\SubcategoryController::routes();
    \App\Http\Controllers\ProductController::routes();
    \App\Http\Controllers\CheckInController::routes();
    \App\Http\Controllers\CheckOutController::routes();
    \App\Http\Controllers\HistoryController::routes();
    \App\Http\Controllers\WidgetsController::routes();
    \App\Http\Controllers\SettingController::routes();
    \App\Http\Controllers\SaleController::routes();
    \App\Http\Controllers\SaleItemController::routes();
    \App\Http\Controllers\PurchaseController::routes();
    \App\Http\Controllers\PurchasePaymentController::routes();
    \App\Http\Controllers\CustomerBalanceController::routes();
    \App\Http\Controllers\SupplierBalanceController::routes();
    \App\Http\Controllers\SupplierFundController::routes();
    \App\Http\Controllers\SalePaymentController::routes();
    \App\Http\Controllers\LanguageController::routes();
    \App\Http\Controllers\CapitalDepositController::routes();
    \App\Http\Controllers\CapitalWithdrawController::routes();
    \App\Http\Controllers\CapitalBalanceController::routes();
    \App\Http\Controllers\ExpenseCategoryController::routes();
    \App\Http\Controllers\ExpenseController::routes();
    \App\Http\Controllers\SmsController::routes();
    \App\Http\Controllers\TransactionController::routes();
    \App\Http\Controllers\ReportsController::routes();
});
Route::middleware(['auth'])->group(function () {
    Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
        ->name('ckfinder_connector');

    Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
        ->name('ckfinder_browser');

    Route::any('/ckfinder/examples/{example?}', '\CKSource\CKFinderBridge\Controller\CKFinderController@examplesAction')
        ->name('ckfinder_examples');


    Route::get('/{url?}', fn() => view('layouts.dashboard', [
        "list_languages" => \App\Models\Language::query()->select(['id', 'name'])->get()->pluck('id', 'name')
    ]))->name('Admin');
});


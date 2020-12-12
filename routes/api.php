<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers as CC;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->post('/user', function (Request $request) {
    return $request->user()->only(['id', 'name', 'email']);
});

Route::middleware('auth:sanctum')->name('Api.')->group(function () {
    CC\CategoryController::routes();
    CC\SupplierController::routes();
    CC\CustomerController::routes();
    CC\EmployeeController::routes();
    CC\EmployeeSalaryController::routes();
    CC\BrandController::routes();
    CC\UnitController::routes();
    CC\ProductController::routes();
    CC\HistoryController::routes();
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
    CC\SaleReturnController::routes();
    CC\PurchaseReturnController::routes();
});

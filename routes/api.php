<?php

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers as CC;
use Illuminate\Validation\ValidationException;

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

Route::middleware('auth:sanctum')->post('/auth/user', function (Request $request) {
    return auth()->user()->only(['id', 'name', 'email']);
});

Route::post('/auth/login', function (Request $request) {
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

Route::middleware('auth:sanctum')->name('Api.')->group(function () {
    Route::post('my/summery', function (Request $request) {
        $date = \Carbon\Carbon::parse($request->post('date'))->toDateString();

        $orders = \App\Models\Order::query()
            ->whereDate('created_at', $date)
            ->where('user_id', '=', auth()->id());

        $collections = \App\Models\OrderCollection::query()
            ->whereDate('created_at', $date)
            ->where('user_id', '=', auth()->id());

        return response()->json([
            "order_amount" => $orders->sum('total'),
            "order_quantity" => $orders->count('id'),
            "order_paid" => $orders->sum('paid'),
            "collection_amount" => $collections->sum('payment_amount'),
            "collection_quantity" => $collections->count('id')
        ]);
    });
    Route::post('customers/search', [CC\CustomerController::class, 'search']);
    Route::post('products/search', [CC\ProductController::class, 'search']);
    Route::post('orders/store', [CC\OrderController::class, 'store']);
    Route::post('my-orders/list', [CC\OrderController::class, 'myOrders']);
    Route::post('my-orders/{order}/delete', [CC\OrderController::class, 'delete']);
    Route::post('my-orders/{order}/delete-items/{order_item}', [CC\OrderController::class, 'deleteOrderItem']);
    Route::post('my-collections/store', [CC\OrderCollectionController::class, 'store']);
    Route::post('my-collections/list', [CC\OrderCollectionController::class, 'myCollections']);
    Route::post('my-collections/{order_collection}/delete', [CC\OrderCollectionController::class, 'delete']);
//    CC\CategoryController::routes();
//    CC\SupplierController::routes();
//    CC\CustomerController::routes();
//    CC\EmployeeController::routes();
//    CC\EmployeeSalaryController::routes();
//    CC\BrandController::routes();
//    CC\UnitController::routes();
//    CC\ProductController::routes();
//    CC\HistoryController::routes();
//    CC\SettingController::routes();
//    CC\SaleController::routes();
//    CC\SaleItemController::routes();
//    CC\PurchaseController::routes();
//    CC\PurchasePaymentController::routes();
//    CC\PurchaseItemController::routes();
//    CC\CustomerBalanceController::routes();
//    CC\SupplierBalanceController::routes();
//    CC\SalePaymentController::routes();
//    CC\LanguageController::routes();
//    CC\CapitalDepositController::routes();
//    CC\CapitalWithdrawController::routes();
//    CC\CapitalBalanceController::routes();
//    CC\ExpenseCategoryController::routes();
//    CC\ExpenseController::routes();
//    CC\SmsController::routes();
//    CC\TransactionController::routes();
//    CC\ReportsController::routes();
//    CC\SaleReturnController::routes();
//    CC\PurchaseReturnController::routes();
});

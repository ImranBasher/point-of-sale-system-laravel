<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Brand\BrandController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\RolePermission\Permission\PermissionController;
use App\Http\Controllers\RolePermission\Role\RoleController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Dues\DuesPurchaseController;
use App\Http\Controllers\Dues\DuesSelesController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Origin\OriginController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Purchase\PurchaseController;
use App\Http\Controllers\Sale\SaleController;
use App\Http\Controllers\SalesCart\SalesCartController;
use App\Http\Controllers\Subcategory\SubcategoryController;
use App\Http\Controllers\Unit\UnitController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/loggin', [LoginController::class, 'showLoginForm'] )->name('show-login-form');
Route::post('/loggin', [LoginController::class, 'login'] )->name('loggin');
Route::post('/logout', [LoginController::class, 'login'] )->name('logout');

Route::get('/register', [RegisterController::class, 'showRegisterForm'] )->name('show-register-form');

Auth::routes();

Route::get('/admin/dashboard', function () {
    return view('admin.layout.main');
})->name('admin.dashboard');


Route::get('/home', [HomeController::class, 'index'])->name('home');   // *********** it will be changed like


//Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
//Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store'); // For storing a category
//Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
//Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');

//Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
//Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
//Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
//Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
//Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

//Route::resource('categories', CategoryController::class);

//    route list command :      php artisan route:list

//Route::group(['middleware' => ['auth' ]], function () {
//    Route::group(['middleware' => ['role:admin|admin' ]], function () {
//    Route::group(['middleware' => ['check_user_role']], function () {

    Route::resource('roles', RoleController::class);
    Route::get('roles/{id}/add-permission', [RoleController::class, 'addPermissionToRole'])->name('add.give-permission');
    Route::put('roles/{id}/give-permission', [RoleController::class, 'givePermissionToRole'])->name('roles.give-permission');
    Route::resource('permissions', PermissionController::class);

    Route::resource('users', UserController::class);
//    Route::get('/users-all', [UserController::class, 'allUsers'])->name('users.all');
    Route::get('/users-customer', [UserController::class, 'customer'])->name('users.customer');
    Route::get('/users-admin', [UserController::class, 'admin'])->name('users.admin');
    Route::get('/users-supplier', [UserController::class, 'supplier'])->name('users.supplier');
    Route::get('/customers_info', [UserController::class, 'customerInfo'])->name('customers_info');
    Route::get('/suppliers', [CartController::class, 'users'])->name('suppliers');
    Route::get('helper-users', [HelperController::class, 'users'])->name('users');
    Route::resource('pictures', ProductController::class);


    Route::resource('units', UnitController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('origins', OriginController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);


    Route::resource('purchases', PurchaseController::class);
    Route::resource('/carts', CartController::class);
    Route::get('show-purchase', [PurchaseController::class, 'showPurchase'])->name('show-purchase');
    Route::post('filtered-purchase', [PurchaseController::class, 'filterPurchase'])->name('filtered-purchase');
    Route::get('show-purchase-dues', [PurchaseController::class, 'showPurchaseDues'])->name('show-purchase-dues');
    Route::get('show-transaction/{id}', [PurchaseController::class, 'showTransactions'])->name('show-transaction');
    Route::get('print-transaction/{id}', [PurchaseController::class, 'printTransactions'])->name('print-transaction');


    Route::Resource('sales', SaleController::class);
    Route::Resource('sales_cart', SalesCartController::class);
    Route::get('show-sales', [SaleController::class, 'showSales'])->name('show-sales');
    Route::post('filtered-sales', [SaleController::class, 'filterSales'])->name('filtered-sales');
    Route::get('show-sales-dues', [SaleController::class, 'showSalesDues'])->name('show-sales-dues');
    Route::get('show-sale-transaction/{id}', [SaleController::class, 'showTransactions'])->name('show-sale-transaction');
    Route::get('print-sale-transaction/{id}', [SaleController::class, 'printTransactions'])->name('print-sale-transaction');


    Route::Resource('dues_purchase', DuesPurchaseController::class);
    Route::get('purchase_pay',[DuesPurchaseController::class, 'showPurchasePayment'])->name('purchase-pay.show');
    Route::Resource('dues_sales', DuesSelesController::class);
    Route::get('sales_pay',[DuesSelesController::class, 'showSalesPayment'])->name('sales_pay.show');

//});

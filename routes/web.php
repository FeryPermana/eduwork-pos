<?php

use App\Http\Controllers\Apps\CategoryController;
use App\Http\Controllers\Apps\CustomerController;
use App\Http\Controllers\Apps\PermissionController;
use App\Http\Controllers\apps\ProductController;
use App\Http\Controllers\Apps\ProfitController;
use App\Http\Controllers\Apps\RoleController;
use App\Http\Controllers\Apps\SaleController;
use App\Http\Controllers\Apps\TransactionController;
use App\Http\Controllers\apps\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes(['register' => false]);


//prefix "apps"
Route::prefix('apps')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    //middleware "auth"
    Route::group(['middleware' => ['auth']], function () {
        Route::resource('/categories', CategoryController::class, ['as' => 'apps'])
            ->middleware('permission:categories.index|categories.create|categories.edit|categories.delete');
    });

    Route::group(['middleware' => ['auth']], function () {
        Route::resource('/products', ProductController::class, ['as' => 'apps'])
            ->middleware('permission:products.index|products.create|products.edit|products.delete');
        Route::get('/api/products', [ProductController::class, 'api'])->name('apps.product.api');

        Route::resource('/customers', CustomerController::class, ['as' => 'apps'])
            ->middleware('permission:customers.index|customers.create|customers.edit|customers.delete');
        Route::get('/api/customers', [CustomerController::class, 'api'])->name('apps.product.api');

        Route::resource('/roles', RoleController::class, ['as' => 'apps'])
            ->middleware('permission:roles.index|roles.create|roles.edit|roles.delete');

        Route::resource('/permissions', PermissionController::class, ['as' => 'apps'])
            ->middleware('permission:users.index|users.create|users.edit|users.delete');

        //route resource users
        Route::resource('/users', UserController::class, ['as' => 'apps'])
            ->middleware('permission:users.index|users.create|users.edit|users.delete');

        //route transaction
        Route::get('/transactions', [TransactionController::class, 'index'])->name('apps.transactions.index');

        //route api product
        Route::get('api-product/transactions/', [TransactionController::class, 'apiProduct'])->name('apps.transactions.apiProduct');

        // route-api transaction
        Route::get('api/transactions/', [TransactionController::class, 'api'])->name('apps.transactions.api');

        //route transaction searchProduct
        Route::post('/transactions/searchProduct', [TransactionController::class, 'searchProduct'])->name('apps.transactions.searchProduct');

        //route transaction addToCart
        Route::post('/transactions/addToCart', [TransactionController::class, 'addToCart'])->name('apps.transactions.addToCart');

        //route transaction destroyCart
        Route::delete('/transactions/destroyCart/{id}', [TransactionController::class, 'destroyCart'])->name('apps.transactions.destroyCart');

        //route transaction store
        Route::post('/transactions/store', [TransactionController::class, 'store'])->name('apps.transactions.store');

        //route transaction print
        Route::get('/transactions/print', [TransactionController::class, 'print'])->name('apps.transactions.print');

        //route sales index
        Route::get('/sales', [SaleController::class, 'index'])->middleware('permission:sales.index')->name('apps.sales.index');

        //route sales export excel
        Route::get('/sales/export', [SaleController::class, 'export'])->name('apps.sales.export');

        //route sales print pdf
        Route::get('/sales/pdf', [SaleController::class, 'pdf'])->name('apps.sales.pdf');

        //route profits index
        Route::get('/profits', [ProfitController::class, 'index'])->middleware('permission:profits.index')->name('apps.profits.index');

        //route profits export
        Route::get('/profits/export', [ProfitController::class, 'export'])->name('apps.profits.export');

        //route profits pdf
        Route::get('/profits/pdf', [ProfitController::class, 'pdf'])->name('apps.profits.pdf');
    });
});

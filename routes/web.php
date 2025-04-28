<?php



use Illuminate\Support\Facades\Route;
// *1

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/test', function () {
    return view('test');
});
// *1
Route::get('login', [LoginController::class, 'login']);
Route::post('action-login', [LoginController::class, 'actionLogin']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::group(['middleware' => 'auth'], function () {
    Route::prefix('report')->group(function () {
        Route::get('/daily', [ReportController::class, 'dailyReport'])->name('report.daily');
        Route::get('/weekly', [ReportController::class, 'weeklyReport'])->name('report.weekly');
        Route::get('/monthly', [ReportController::class, 'monthlyReport'])->name('report.monthly');
        Route::get('/best-seller', [ReportController::class, 'bestSellerReport'])->name('report.best-seller');
    });

    // resource dapat mengcover post get delete
    Route::resource('dashboard', DashboardController::class);
    Route::resource('product', ProductController::class);
    Route::resource('sale', SaleController::class);

    Route::resource('categories', CategoriesController::class);
    Route::resource('levels', LevelController::class);


    Route::resource('user', UserController::class);
    route::resource('pos', TransactionController::class);

    route::get('print/{id}', [TransactionController::class, 'print'])->name('print');
    route::get('get-product/{id}', [TransactionController::class, 'getProduct']);
    route::get('stock', [SaleController::class, 'stock'])->name('stock');


    route::get('edit', [TransactionController::class, 'indexsale']);


    // ketka sudah membuat di BelajarController(method function) kemudian tambah di web.php

});

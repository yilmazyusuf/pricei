<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\PlatformsController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/', [IndexController::class, 'index']);
    Route::post('products/scrape', [ProductController::class, 'scrape'])->name('products.scrape');
    Route::post('products/track/{id}', [ProductController::class, 'track'])->name('products.track');
    Route::post('products/updateStatus', [ProductController::class, 'updateStatus'])->name('products.updateStatus');
    Route::any('products/detail/{id}', [ProductController::class, 'showDetail'])->name('products.detail');

    Route::resource('products', ProductController::class);
    Route::resource('platforms', PlatformsController::class);
});


Auth::routes();

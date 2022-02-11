<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\PlatformsController;
use App\Http\Controllers\ProductCategoriesController;
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

Route::get('/', [IndexController::class, 'index']);
Route::resource('products', ProductController::class);
Route::resource('products_categories', ProductCategoriesController::class);
Route::post('products/scrape', [ProductController::class, 'scrape'])->name('products.scrape');
Route::resource('platforms', PlatformsController::class);



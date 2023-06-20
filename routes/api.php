<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminApi\UsersController;
use App\Http\Controllers\AdminApi\CategoryProduct;
use App\Http\Controllers\AdminApi\BrandProduct;
use App\Http\Controllers\AdminApi\OrderDetail;
use App\Http\Controllers\AdminApi\ProductController;
use App\Http\Controllers\AdminApi\ProductCheckout;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resources([
    'users' => UsersController::class,
    'category-product' => CategoryProduct::class,
    'brand-product' => BrandProduct::class,
    'product' => ProductController::class,
    'order' => ProductCheckout::class,
    'order-detail' => OrderDetail::class,
]);

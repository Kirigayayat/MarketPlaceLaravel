<?php

use App\Http\Controllers\api\AlamatTokoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\ProdukController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\TokoController;

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

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('user')->group(function () {
    Route::get('home', [HomeController::class, 'getHome']);
    Route::put('update-user/{id}', [AuthController::class, 'update']);
    Route::post('upload-user/{id}', [AuthController::class, 'upload']);
    Route::resource('toko', TokoController::class);
    Route::get('toko-user/{id}', [TokoController::class, 'cekToko']);
    Route::resource('alamat-toko', AlamatTokoController::class);

    Route::resource('category', CategoryController::class);

    Route::post('upload/produk', [ProdukController::class, 'upload']);
    Route::resource('produk', ProdukController::class);
    Route::get('produk-detail/{id}', [ProdukController::class, 'detailProduct']);

    Route::post('upload/{path}', [BaseController::class, 'upload']);
});

Route::middleware('admin')->group(function () {
    Route::resource('category', CategoryController::class);
    Route::resource('slider', SliderController::class);
});

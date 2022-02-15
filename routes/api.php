<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(UserController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    // Route::middleware('auth:api')->group(function () {
    //     Route::get('/product', 'index');
    // });
});

Route::controller(ProductController::class)->middleware('auth:api')->group(function () {
    Route::get('/category', 'categoryList');
    Route::get('/product', 'index');
    Route::post('/product',  'store');
    Route::get('/product/{id}', 'show');
    Route::post('/product/update/{id}', 'update');
    Route::delete('/product/{id}', 'destroy');
});

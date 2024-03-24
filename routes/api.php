<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('category',[ApiController::class,'getCategories']);
Route::get('products',[ApiController::class,'getProductByCategory']);
Route::get('products/last',[ApiController::class,'getProductLast']);

//Route::get('category/{id}/products',[ApiController::class,'getProductByCategory']);
Route::middleware('auth:sanctum')->post('cart/add',[ApiController::class,'addToCart']);
Route::get('cart',[ApiController::class,'getCart']);
Route::post('/login',[ApiController::class,'login']);
Route::post('/register',[ApiController::class,'register']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

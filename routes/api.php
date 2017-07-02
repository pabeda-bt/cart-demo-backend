<?php

use Illuminate\Http\Request;

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


Route::prefix('admin')->group(function (){
    Route::prefix('product')->group(function (){
       Route::get('/{id}','Admin\ProductController@show');
       Route::get('/','Admin\ProductController@get');
       Route::post('/','Admin\ProductController@post');
       Route::put('/{id}','Admin\ProductController@put');
       Route::delete('/{id}','Admin\ProductController@delete');
    });
});


Route::prefix('user')->group(function (){
    Route::prefix('cart')->group(function (){
        Route::post('/add-to-cart','User\CartController@addToCart');
        Route::delete('/{id}','User\CartController@deleteItem');
        Route::get('/','User\CartController@getCart');
        Route::get('/order','User\CartController@order');
    });

    Route::prefix('auth')->group(function (){
        Route::post('/register','User\AuthController@register');
        Route::post('/login','User\AuthController@login');
    });
});

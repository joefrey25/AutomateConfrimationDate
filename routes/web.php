<?php

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

use App\Product;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', 'ProductsController@index');
Route::get('/products/create', 'ProductsController@create');
Route::get('/products/show/{product}', 'ProductsController@show');
Route::post('/products', 'ProductsController@store');


Route::get('/orders', 'OrdersController@index');
Route::get('/orders/show/{order}', 'OrdersController@show');
Route::post('/orders/confirm', 'OrdersController@confirm');
Route::post('/orders/confirmDelivery', 'OrdersController@confirmDelivery');

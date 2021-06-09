<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('category', 'CategoryController@index');
Route::group(['prefix' => 'category'], function () {
    Route::post('add', 'CategoryController@add');
    Route::get('edit/{id}', 'CategoryController@edit');
    Route::post('update/{id}', 'CategoryController@update');
    Route::delete('delete/{id}', 'CategoryController@delete');
    Route::get('/search', 'CategoryController@getCategories');
});

Route::get('products', 'ProductController@index');
Route::group(['prefix' => 'products'], function () {
    Route::post('add', 'ProductController@add');
    Route::get('edit/{id}', 'ProductController@edit');
    Route::post('update/{id}', 'ProductController@update');
    Route::delete('delete/{id}', 'ProductController@delete');
    Route::get('show/{category_id}', 'ProductController@show');
    Route::get('/search', 'ProductController@getProducts');
});

Route::get('cart', 'CartController@index');
Route::group(['prefix' => 'cart'], function () {
    Route::post('add', 'CartController@add');
    Route::get('show/{user_id}', 'CartController@show');
    Route::post('update/{cart_id}', 'CartController@update');
    Route::delete('delete/{id}', 'CartController@delete');
    Route::delete('deleteall/{id}', 'CartController@deleteAllUserItems');
});

Route::get('order', 'OrderController@index');
Route::group(['prefix' => 'order'], function () {
    Route::post('add', 'OrderController@add');
    Route::get('show/{user_id}', 'OrderController@show');
    Route::post('update/{order_id}', 'OrderController@update');
    Route::delete('delete/{id}', 'OrderController@delete');
});

Route::get('brand', 'BrandController@index');
Route::group(['prefix' => 'brand'], function () {
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::post('/update/{id}', 'AuthController@update');
Route::post('/logout', 'AuthController@logout')->middleware('auth:sanctum');

Route::get('/logout', 'AuthController@logout')->middleware('auth:sanctum');
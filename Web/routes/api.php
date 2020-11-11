<?php
 
use Illuminate\Http\Request;
 

Route::get('category', 'CategoryController@index');
Route::group(['prefix' => 'category'], function () {
    Route::post('add', 'CategoryController@add');
    Route::get('edit/{id}', 'CategoryController@edit');
    Route::post('update/{id}', 'CategoryController@update');
    Route::delete('delete/{id}', 'CategoryController@delete');
});
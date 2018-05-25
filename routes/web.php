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

/**
 * Danh sách các route cho danh mục
 */
Route::get('/categories', 'CategoryController@index');
Route::get('/categories/create', 'CategoryController@create');
Route::post('/categories', 'CategoryController@createSave');
Route::get('/categories/edit/{id}', 'CategoryController@edit');
Route::post('/categories/edit-save', 'CategoryController@editSave');
Route::get('/categories/destroy/{id}', 'CategoryController@destroy');

/**
 * Danh sách các route cho sản phẩm
 */
Route::get('/products', 'ProductController@index');
Route::get('/products/create', 'ProductController@create');
Route::post('/products', 'ProductController@createSave');
Route::get('/products/edit/{id}', 'ProductController@edit');
Route::post('/products/edit-save', 'ProductController@editSave');
Route::get('/products/destroy/{id}', 'ProductController@destroy');
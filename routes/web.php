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

  use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\Facades\Route;
  /**
   * Danh sách các route cho danh mục
   */


  Route::get('/admin/categories', 'CategoryController@index')->name('categories');
  Route::get('/admin/categories/create', 'CategoryController@create');
  Route::post('/admin/categories', 'CategoryController@createSave');
  Route::get('/admin/categories/edit/{id}', 'CategoryController@edit');
  Route::post('/admin/categories/edit-save', 'CategoryController@editSave');
  Route::get('/admin/categories/destroy/{id}', 'CategoryController@destroy');

  /**
   * Danh sách các route cho sản phẩm
   */
  Route::get('/admin/products', 'ProductController@index')->name('products');
  Route::get('/admin/products/create', 'ProductController@create');
  Route::post('/admin/products', 'ProductController@createSave');
  Route::get('/admin/products/edit/{id}', 'ProductController@edit');
  Route::post('/admin/products/edit-save', 'ProductController@editSave');
  Route::get('/admin/products/destroy/{id}', 'ProductController@destroy');

  Auth::routes();

  Route::get('/admin/login', 'AdminController@showLoginForm')->name('admin-login');
  Route::get('/admin/register', 'AdminController@showRegisterForm')->name('admin-register');
//  Route::get('/admin/logout', 'AdminController@logout')->name('admin-logout');
  Route::post('/admin/login', 'AdminController@login');
  Route::post('/admin/register', 'AdminController@register');

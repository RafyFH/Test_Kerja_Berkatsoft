<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard');

Route::get('/customer','CustomersController@index');
Route::get('/jsoncustomer','CustomersController@json');
Route::post('/store-customer','CustomersController@store');
Route::get('/get-customer/{id}','CustomersController@edit');
Route::post('/update-customer/{id}','CustomersController@update');
Route::get('/delete-customer/{id}','CustomersController@destroy');

Route::get('/produk','ProduksController@index');
Route::get('/jsonproduk','ProduksController@json');
Route::post('/store-produk','ProduksController@store');
Route::get('/get-produk/{id}','ProduksController@edit');
Route::post('/update-produk/{id}','ProduksController@update');
Route::get('/delete-produk/{id}','ProduksController@destroy');

Route::get('/sales-order','SalesOrderController@index')->name('sales-order');
Route::get('/jsonsales','SalesOrderController@json');
Route::get('/findproduk/{id}','SalesOrderController@findproduk');
Route::get('/sales-order-tambah','SalesOrderController@create');
Route::post('/sales-order-store','SalesOrderController@store')->name('sales-store');
Route::get('/get-sales-order/{id}','SalesOrderController@edit');
Route::post('/update-sales-order/{id}','SalesOrderController@update');
Route::get('/delete-sales-order/{id}','SalesOrderController@destroy');
Route::get('/delete-produk-sales/{id}','SalesOrderController@delete_produk');
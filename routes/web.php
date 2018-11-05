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

Route::resource('orders', 'OrdersController');
Route::post('orders/{id}', 'OrdersController@update');
Route::post('searchOrders', 'OrdersController@search');
Route::resource('invoices', 'InvoiceController');
Route::get('invoices/create/{orderId}', 'InvoiceController@create');
Route::resource('slips', 'SlipController');
Route::get('slips/create/{orderId}', 'SlipController@create');
Route::resource('purchases', 'PurchaseController');
Route::resource('items', 'ItemsController');
Route::resource('godowns', 'GodownsController');
Route::get('stock/closing/{date?}/{item?}', 'StockController@itemStock');
Route::get('stock/transfer', 'StockController@transferView');
Route::post('stock/transfer', 'StockController@transfer');
Route::get('stock/transfer/logs', 'StockController@transferLogs');
Route::get('daybook/{date?}/{item?}', 'DaybookController@view');
Route::get('clients/balance', 'ClientsController@balance');

Auth::routes();

Route::get('home', 'OrdersController@pending')->name('home');
Route::get('/', 'OrdersController@pending')->name('home');
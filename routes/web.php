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

Route::get('/', 'HomeController@index');
Route::post('/contact-submit', 'ContentsController@contactSubmit')->name('contact-submit');
Route::get('/products', 'ProductsController@index')->name('product-index');
Route::get('/product-category/{slug}', 'ProductsController@productByCategory')->name('product-by-category');
Route::get('/product/{id}', 'ProductsController@details')->name('product-details');
Route::get('/cart', 'CartsController@cart')->name('cart-index');
Route::post('/add-to-cart', 'CartsController@addToCart')->name('add.to.cart');
Route::patch('/update-cart', 'CartsController@update')->name('update.cart');
Route::post('/place-order', 'CartsController@placeOrder')->name('place.order');
Route::delete('/remove-from-cart', 'CartsController@remove')->name('remove.from.cart');
Route::get('/checkout', 'PaymentController@index')->name('checkout');
Route::match(['get', 'post'],'/payment', 'PaymentController@payment')->name('payment');
Route::get('/{slug}', 'ContentsController@index');

Route::group(['prefix'=>'admin','as'=>'admin.'], function(){
    Route::get('/products', ['as' => 'product.index', 'uses' => 'Admin\ProductsController@index']);
    Route::get('/product/create', ['as' => 'product.create', 'uses' => 'Admin\ProductsController@create']);
    Route::get('/product/{id}/edit', ['as' => 'product.edit', 'uses' => 'Admin\ProductsController@edit']);
    Route::post('/product/update', ['as' => 'product.update', 'uses' => 'Admin\ProductsController@update']);
    Route::post('/product/store', ['as' => 'product.store', 'uses' => 'Admin\ProductsController@store']);
    Route::post('/product/delete', ['as' => 'product.delete', 'uses' => 'Admin\ProductsController@delete']);
    
    // Orders
    Route::get('/orders', ['as' => 'order.index', 'uses' => 'Admin\OrdersController@index']);
    Route::get('/order/{id}/details', ['as' => 'order.details', 'uses' => 'Admin\OrdersController@details']);
    
    //User Inquiries
    Route::get('/user-inquiries', ['as' => 'user.inquiries', 'uses' => 'Admin\AdminController@userInquiries']);

});

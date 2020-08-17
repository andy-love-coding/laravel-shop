<?php

Route::redirect('/', '/products')->name('root');
Route::get('products', 'ProductsController@index')->name('products.index');
Route::get('products/{product}', 'ProductsController@show')->name('products.show')->where(['product' => '[0-9]+']);
Auth::routes(['verify' => true]);

// auth 中间件代表需要登录，verified 中间件代表需要经过邮箱认证
Route::group(['middleware' => ['auth', 'verified']], function() {
  Route::get('user_addresses', 'UserAddressesController@index')->name('user_addresses.index');
  Route::get('user_addresses/create', 'UserAddressesController@create')->name('user_addresses.create');
  Route::post('user_addresses', 'UserAddressesController@store')->name('user_addresses.store');
  Route::get('user_addresses/{user_address}', 'UserAddressesController@edit')->name('user_addresses.edit');
  Route::put('user_addresses/{user_address}', 'UserAddressesController@update')->name('user_addresses.update');
  Route::delete('user_addresses/{user_address}', 'UserAddressesController@destroy')->name('user_addresses.destroy');

  Route::post('products/{product}/favorite', 'ProductsController@favor')->name('products.favor');
  Route::delete('products/{product}/favorite', 'ProductsController@disfavor')->name('products.disfavor');
  Route::get('products/favorites', 'ProductsController@favorites')->name('products.favorites');

  Route::post('cart', 'CartController@add')->name('cart.add');
  Route::get('cart', 'CartController@index')->name('cart.index');
  Route::delete('cart/{sku}', 'CartController@remove')->name('cart.remove');

  Route::post('orders', 'OrdersController@store')->name('orders.store');
  Route::get('orders', 'OrdersController@index')->name('orders.index');
});
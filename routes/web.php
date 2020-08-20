<?php

Route::redirect('/', '/products')->name('root');
Route::get('products', 'ProductsController@index')->name('products.index');
Route::get('products/{product}', 'ProductsController@show')->name('products.show')->where(['product' => '[0-9]+']);
Auth::routes(['verify' => true]);
Route::get('alipay', function() {
  return app('alipay')->web([
      'out_trade_no' => time(),
      'total_amount' => '1',
      'subject' => 'test subject - 测试',
  ]);
});

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
  Route::get('orders/{order}', 'OrdersController@show')->name('orders.show');

  Route::get('payment/{order}/alipay', 'PaymentController@payByAlipay')->name('payment.alipay');
  Route::get('payment/alipay/return', 'PaymentController@alipayReturn')->name('payment.alipay.return');
  
  Route::post('orders/{order}/received', 'OrdersController@received')->name('orders.received');

  Route::get('orders/{order}/review', 'OrdersController@review')->name('orders.review.show');
  Route::post('orders/{order}/review', 'OrdersController@sendReview')->name('orders.review.store');
});
Route::post('payment/alipay/notify', 'PaymentController@alipayNotify')->name('payment.alipay.notify');
<?php

/**
 * ========================================
 *
 *   CART PROTECTED ROUTES
 *
 * ========================================
 */

Route::group([
	'prefix'     => 'order',
	'middleware' => 'auth'
], function() {

	Route::get('/list',                           'ReadController@getList');
	Route::get('/detail/{id}',                    'ReadController@getDetail');
	Route::get('/thank-you/{id}',                 'ReadController@showThankyou');
	Route::post('/set-order-transaction',         'UpdateController@setOrderTransaction');

});
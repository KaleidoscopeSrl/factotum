<?php

/**
 * ========================================
 *
 *   CART PROTECTED ROUTES
 *
 * ========================================
 */

Route::group([
	'prefix'     => 'payment',
], function() {

	$middlewares = [];

	if ( !config('factotum.guest_cart') ) {
		$middlewares['middleware'] = 'auth';
	}

	Route::group($middlewares, function () {

		Route::group([ 'prefix' => 'stripe' ], function() {
			Route::post('/init-payment-intent',         'StripeController@initPaymentInit');
			Route::post('/get-transaction-id',          'StripeController@getTransactionId');
		});

		Route::group([ 'prefix' => 'paypal' ], function() {
			Route::post('/init-payment-intent',         'PayPalController@initPaymentInit');
			Route::post('/get-transaction-id',          'PayPalController@getTransactionId');
		});

	});


});
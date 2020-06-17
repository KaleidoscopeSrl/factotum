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
	'middleware' => 'auth'
], function() {

	Route::group([ 'prefix' => 'stripe' ], function() {
		Route::post('/init-payment-intent',         'StripeController@initPaymentInit');
	});

	Route::group([ 'prefix' => 'paypal' ], function() {
		Route::post('/init-payment-intent',         'PayPalController@initPaymentInit');
		Route::post('/get-transaction-id',          'PayPalController@getTransactionId');
	});

});
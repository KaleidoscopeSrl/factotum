<?php

/**
 *
 *   USERS
 *
 */

Route::group([
	'prefix'     => 'setting',
	'middleware' => 'auth:api',
	'namespace'  => 'Setting'
], function () {

	Route::get('/get-settings',         'Controller@getSettings');

	Route::get('/brands-via-pim',                    'Controller@brandsViaPim');
	Route::get('/product-categories-via-pim',        'Controller@productCategoriesViaPim');
	Route::get('/products-via-pim',                  'Controller@productsViaPim');

	Route::get('/get-shipping-options',              'Controller@getShippingOptions' );
	Route::get('/get-payment-options',               'Controller@getPaymentOptions' );


	Route::group(['middleware' => 'can:manage-settings,Kaleidoscope\Factotum\Role'], function() {
		Route::post('/save-homepage-languages',       'Controller@saveHomepageByLanguage');
	});


});

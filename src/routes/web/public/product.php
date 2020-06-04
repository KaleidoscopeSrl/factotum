<?php

/**
 *
 *   PRODUCT
 *
 */

Route::group([
	'namespace'  => 'Product'
], function () {


	Route::get('/prodotto/{productSlug}',    'ReadController@getProductBySlug');
	Route::post('/ricerca-prodotto',         'ReadController@searchProduct');

});





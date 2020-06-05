<?php

/**
 *
 *   PRODUCT
 *
 */

Route::group([
	'namespace'  => 'Ecommerce\Product'
], function () {


	Route::get('/prodotti/{productSlug}',    'ReadController@getProductBySlug');
	Route::post('/ricerca-prodotto',         'ReadController@searchProduct');

});





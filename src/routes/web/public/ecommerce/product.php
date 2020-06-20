<?php

/**
 *
 *   PRODUCT
 *
 */

Route::group([
	'prefix'    => 'product'
], function () {

	Route::get('/search',          'ReadController@showSearchProduct');
	Route::post('/search',         'ReadController@searchProduct');

});





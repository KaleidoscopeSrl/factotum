<?php

/**
 *
 *   PRODUCT VARIANTS
 *
 */

Route::group([
	'prefix'     => 'product-variant',
	'middleware' => 'auth:api',
	'namespace'  => 'ProductVariant'
], function() {

	Route::group(['middleware' => 'can:create,Kaleidoscope\Factotum\ProductVariant'], function() {
		Route::post('/create',             'CreateController@create');
	});

	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\ProductVariant'], function() {
		Route::get('/list/{productId}',                'ReadController@getList');
		Route::post('/list-paginated/{productId}',     'ReadController@getListPaginated');
		Route::get('/detail/{id}',                     'ReadController@getDetail');
	});

	Route::group(['middleware' => 'can:update,Kaleidoscope\Factotum\ProductVariant,id'], function() {
		Route::post('/update/{id}',        'UpdateController@update');
	});

	Route::group(['middleware' => 'can:delete,Kaleidoscope\Factotum\ProductVariant,id'], function() {
		Route::delete('/delete/{id}',                'DeleteController@remove');
		Route::post('/delete-product-variants',      'DeleteController@removeProductVariants');
	});

});

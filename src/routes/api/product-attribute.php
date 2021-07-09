<?php

/**
 *
 *   PRODUCT ATTRIBUTES
 *
 */

Route::group([
	'prefix'     => 'product-attribute',
	'middleware' => 'auth:api',
	'namespace'  => 'ProductAttribute'
], function() {

	Route::group(['middleware' => 'can:create,Kaleidoscope\Factotum\ProductAttribute'], function() {
		Route::post('/create',             'CreateController@create');
	});

	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\ProductAttribute'], function() {
		Route::get('/list',                'ReadController@getList');
		Route::post('/list-paginated',     'ReadController@getListPaginated');
		Route::get('/detail/{id}',         'ReadController@getDetail');
	});

	Route::group(['middleware' => 'can:update,Kaleidoscope\Factotum\ProductAttribute,id'], function() {
		Route::post('/update/{id}',        'UpdateController@update');
	});

	Route::group(['middleware' => 'can:delete,Kaleidoscope\Factotum\ProductAttribute,id'], function() {
		Route::delete('/delete/{id}',                  'DeleteController@remove');
		Route::post('/delete-product-attributes',      'DeleteController@removeProductAttributes');
	});

});

<?php

/**
 *
 *   PRODUCTS
 *
 */

Route::group([
	'prefix'     => 'product',
	'middleware' => 'auth:api',
	'namespace'  => 'Product'
], function () {


	Route::group(['middleware' => 'can:create,Kaleidoscope\Factotum\Product'], function() {
		Route::post('/create',                       'CreateController@create');
	});

	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\Product'], function() {
		Route::get('/list',                          'ReadController@getList');
		Route::post('/list-paginated',               'ReadController@getListPaginated');
		Route::get('/detail/{id}',                   'ReadController@getDetail');

	});

	Route::group(['middleware' => 'can:update,Kaleidoscope\Factotum\Product,id'], function() {
		Route::post('/update/{id}',                  'UpdateController@update');
	});

	Route::group(['middleware' => 'can:delete,Kaleidoscope\Factotum\Product,id'], function() {
		Route::delete('/delete/{id}',                'DeleteController@remove');
	});

});



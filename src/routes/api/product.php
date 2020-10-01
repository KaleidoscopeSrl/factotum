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
		Route::post('/duplicate/{id}',               'CreateController@duplicate');
	});

	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\Product'], function() {
		Route::get('/number-by-status',              'ReadController@getNumberByStatus');
		Route::get('/list',                          'ReadController@getList');
		Route::post('/list-paginated',               'ReadController@getListPaginated');
		Route::post('/list-by-search',               'ReadController@getListBySearch');
		Route::get('/detail/{id}',                   'ReadController@getDetail');
	});

	Route::group(['middleware' => 'can:update,Kaleidoscope\Factotum\Product,id'], function() {
		Route::post('/update/{id}',                  'UpdateController@update');
		Route::post('/change-products-status',       'UpdateController@changeProductsStatus');
		Route::post('/change-products-category',     'UpdateController@changeProductsCategory');
	});

	Route::group(['middleware' => 'can:delete,Kaleidoscope\Factotum\Product,id'], function() {
		Route::delete('/delete/{id}',                'DeleteController@remove');
		Route::post('/delete-products',              'DeleteController@removeProducts');
	});

});



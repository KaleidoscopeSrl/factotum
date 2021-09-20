<?php

/**
 *
 *   PRODUCTS
 *
 */

Route::group([
	'prefix'     => 'cart',
	'middleware' => 'auth:api',
	'namespace'  => 'Cart'
], function () {


	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\Cart'], function() {
		Route::post('/list-paginated',               'ReadController@getListPaginated');
		Route::get('/list',                          'ReadController@getList');
		Route::get('/detail/{id}',                   'ReadController@getDetail');
	});

	Route::group(['middleware' => 'can:delete,Kaleidoscope\Factotum\Cart,id'], function() {
		Route::delete('/delete/{id}',                'DeleteController@remove');
		Route::post('/delete-carts',                 'DeleteController@removeCarts');
	});

});



<?php

/**
 *
 *   BRANDS
 *
 */

Route::group([
	'prefix'     => 'brand',
	'middleware' => 'auth:api',
	'namespace'  => 'Brand'
], function () {


	Route::group(['middleware' => 'can:create,Kaleidoscope\Factotum\Brand'], function() {
		Route::post('/create',             'CreateController@create');
	});

	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\Brand'], function() {
		Route::get('/list',                'ReadController@getList');
		Route::post('/list-paginated',     'ReadController@getListPaginated');
		Route::get('/detail/{id}',         'ReadController@getDetail');
	});

	Route::group(['middleware' => 'can:update,Kaleidoscope\Factotum\Brand,id'], function() {
		Route::post('/update/{id}',        'UpdateController@update');
	});

	Route::group(['middleware' => 'can:delete,Kaleidoscope\Factotum\Brand,id'], function() {
		Route::delete('/delete/{id}',      'DeleteController@remove');
		Route::post('/delete-brands',      'DeleteController@removeBrands');
	});


});
<?php

/**
 *
 *   DISCOUNT CODES
 *
 */

Route::group([
	'prefix'     => 'discount-code',
	'middleware' => 'auth:api',
	'namespace'  => 'DiscountCode'
], function () {


	Route::group(['middleware' => 'can:create,Kaleidoscope\Factotum\DiscountCode'], function() {
		Route::post('/create',             'CreateController@create');
	});

	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\DiscountCode'], function() {
		Route::get('/list',                'ReadController@getList');
		Route::post('/list-paginated',     'ReadController@getListPaginated');
		Route::get('/detail/{id}',         'ReadController@getDetail');

	});

	Route::group(['middleware' => 'can:update,Kaleidoscope\Factotum\DiscountCode,id'], function() {
		Route::post('/update/{id}',        'UpdateController@update');
	});

	Route::group(['middleware' => 'can:delete,Kaleidoscope\Factotum\DiscountCode,id'], function() {
		Route::delete('/delete/{id}',               'DeleteController@remove');
		Route::post('/delete-discount-codes',       'DeleteController@removeDiscountCodes');
	});


});
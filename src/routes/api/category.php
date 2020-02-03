<?php

/**
 *
 *   CATEGORY
 *
 */

Route::group([
	'prefix'     => 'category',
	'middleware' => 'auth:api',
	'namespace'  => 'Category'
], function () {


	Route::group(['middleware' => 'can:create,Kaleidoscope\Factotum\Category'], function() {
		Route::post('/create',                              'CreateController@create');
	});

	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\Category,contentTypeId'], function() {
		Route::get('/list/{contentTypeId}',                 'ReadController@getList');
		Route::get('/list-grouped/{contentTypeId}',         'ReadController@getListGrouped');
	});


	Route::group(['middleware' => 'can:readDetail,Kaleidoscope\Factotum\Category,id'], function() {
		Route::get('/detail/{id}',                          'ReadController@getDetail');
	});


	Route::group(['middleware' => 'can:update,Kaleidoscope\Factotum\Category,id'], function() {
		Route::post('/update/{id}',                         'UpdateController@update');
	});

	Route::group(['middleware' => 'can:delete,Kaleidoscope\Factotum\Category,id'], function() {
		Route::delete('/delete/{id}',                       'DeleteController@remove');
	});


});
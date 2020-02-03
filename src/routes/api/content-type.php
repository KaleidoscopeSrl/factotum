<?php

/**
 *
 *   CONTENT TYPE
 *
 */

Route::group([
	'prefix'     => 'content-type',
	'middleware' => 'auth:api',
	'namespace'  => 'ContentType'
], function () {


	Route::group(['middleware' => 'can:create,Kaleidoscope\Factotum\ContentType'], function() {
		Route::post('/create',              'CreateController@create');
	});

	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\ContentType'], function() {
		Route::get('/list',                 'ReadController@getList');
		Route::get('/detail/{id}',          'ReadController@getDetail');
	});

	Route::group(['middleware' => 'can:update,Kaleidoscope\Factotum\ContentType,id'], function() {
		Route::post('/update/{id}',         'UpdateController@update');
	});

	Route::group(['middleware' => 'can:delete,Kaleidoscope\Factotum\ContentType,id'], function() {
		Route::delete('/delete/{id}',       'DeleteController@remove');
	});


});
<?php

/**
 *
 *   USERS
 *
 */

Route::group([
	'prefix'     => 'user',
	'middleware' => 'auth:api',
	'namespace'  => 'User'
], function () {


	Route::group(['middleware' => 'can:create,Kaleidoscope\Factotum\User'], function() {
		Route::post('/create',              'CreateController@create');
	});

	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\User'], function() {
		Route::post('/list',                 'ReadController@getList');
		Route::post('/list-by-role',         'ReadController@getListByRole');
		Route::get('/detail/{id}',           'ReadController@getDetail');
	});

	Route::group(['middleware' => 'can:update,Kaleidoscope\Factotum\User,id'], function() {
		Route::post('/update/{id}',         'UpdateController@update');
	});

	Route::group(['middleware' => 'can:delete,Kaleidoscope\Factotum\User,id'], function() {
		Route::delete('/delete/{id}',       'DeleteController@remove');
	});


});
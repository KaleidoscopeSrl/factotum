<?php

/**
 *
 *   ROLES
 *
 */

Route::group([
	'prefix'     => 'role',
	'middleware' => 'auth:api',
	'namespace'  => 'Role'
], function () {


	Route::group(['middleware' => 'can:create,Kaleidoscope\Factotum\Role'], function() {
		Route::post('/create',             'CreateController@create');
	});

	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\Role'], function() {
		Route::get('/list',                'ReadController@getList');
		Route::get('/detail/{id}',         'ReadController@getDetail');
	});

	Route::group(['middleware' => 'can:update,Kaleidoscope\Factotum\Role,id'], function() {
		Route::post('/update/{id}',        'UpdateController@update');
	});

	Route::group(['middleware' => 'can:delete,Kaleidoscope\Factotum\Role,id'], function() {
		Route::delete('/delete/{id}',      'DeleteController@remove');
	});


});
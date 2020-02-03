<?php

/**
 *
 *   USERS
 *
 */

Route::group([
	'prefix'     => 'capability',
	'middleware' => 'auth:api',
	'namespace'  => 'Capability'
], function () {

	Route::group(['middleware' => 'can:create,Kaleidoscope\Factotum\Capability'], function() {
		Route::post('/create',         'CreateController@create');
	});

	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\Capability'], function() {
		Route::get('/list',            'ReadController@getList');
		Route::get('/detail/{id}',     'ReadController@getDetail');
	});

	Route::group(['middleware' => 'can:update,Kaleidoscope\Factotum\Capability'], function() {
		Route::post('/update/{id}',    'UpdateController@update');
	});

	Route::group(['middleware' => 'can:delete,Kaleidoscope\Factotum\Capability'], function() {
		Route::delete('/delete/{id}',  'DeleteController@remove');
	});

});

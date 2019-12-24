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

	Route::post('/create',         'CreateController@create');
	Route::get('/list',            'ReadController@getList');
	Route::get('/detail/{id}',     'ReadController@getDetail');
	Route::post('/update/{id}',    'UpdateController@update');
	Route::delete('/delete/{id}',  'DeleteController@remove');

});

<?php

/**
 *
 *   CONTENT FIELD
 *
 */

Route::group([
	'prefix'    => 'content-field',
	'namespace' => 'ContentField'
], function () {

	Route::group(['middleware' => 'can:create,Kaleidoscope\Factotum\ContentField'], function() {
		Route::post('/create',                              'CreateController@create');
	});

	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\ContentField,contentTypeId'], function() {
		Route::get('/list/{contentTypeId}',                 'ReadController@getList');
	});

	Route::group(['middleware' => 'can:readDetail,Kaleidoscope\Factotum\ContentField,id'], function() {
		Route::get('/detail/{id}',                          'ReadController@getDetail');
	});

	Route::group(['middleware' => 'can:update,Kaleidoscope\Factotum\ContentField,id'], function() {
		Route::post('/update/{id}',                         'UpdateController@update');
	});

	Route::group(['middleware' => 'can:delete,Kaleidoscope\Factotum\ContentField,id'], function() {
		Route::delete('/delete/{id}',                       'DeleteController@remove');
	});

});
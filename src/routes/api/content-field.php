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

	Route::post('/create',                              'CreateController@create');
	Route::get('/list/{contentTypeId}',                 'ReadController@getList');
	Route::get('/detail/{id}',                          'ReadController@getDetail');
	Route::post('/update/{id}',                         'UpdateController@update');
	Route::delete('/delete/{id}',                       'DeleteController@remove');

});
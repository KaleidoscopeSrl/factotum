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
	Route::post('/list/{contentTypeId}',                'ReadController@getList');
	Route::post('/detail/{id}',                         'ReadController@getDetail');
	Route::post('/update/{id}',                         'UpdateController@update');
	Route::delete('/delete/{id}',                       'DeleteController@remove');

});
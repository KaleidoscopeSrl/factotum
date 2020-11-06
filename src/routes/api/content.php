<?php

/**
 *
 *   CONTENT FIELD
 *
 */

Route::group([
	'prefix'    => 'content',
	'namespace' => 'Content'
], function () {


	Route::group(['middleware' => 'can:create,Kaleidoscope\Factotum\Content'], function() {
		Route::post('/create',                            'CreateController@create');
	});

	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\Content,contentTypeId'], function() {
		Route::post('/list/{contentTypeId}',              'ReadController@getList');
		Route::post('/list-by-search/{contentTypeId}',    'ReadController@getListBySearch');
	});

	Route::group(['middleware' => 'can:readDetail,Kaleidoscope\Factotum\Content,id'], function() {
		Route::get('/detail/{id}',                        'ReadController@getDetail');
	});

	Route::group(['middleware' => 'can:update,Kaleidoscope\Factotum\Content,id'], function() {
		Route::post('/update/{id}',                       'UpdateController@update');
		Route::post('/duplicate/{id}',                    'CreateController@duplicate');
	});

	Route::group(['middleware' => 'can:delete,Kaleidoscope\Factotum\Content,id'], function() {
		Route::delete('/delete/{id}',                     'DeleteController@remove');
	});

});
<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Route::group(['middleware' => ['web']], function () {

	Route::get('/admin/{uri?}', function () { return redirect('/admin/' ); })->where('uri', '.*');

	Route::get('/sitemap', 'Api\Tools\SitemapController@generate');

	Route::get('/{uri?}',  'FrontController@index')->where('uri', '.*');
	Route::post('/{uri?}', 'FrontController@index')->where('uri', '.*');

});


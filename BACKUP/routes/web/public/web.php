<?php

use Illuminate\Support\Facades\Route;

Route::group([
	'middleware' => 'web',
	'namespace'  => 'Kaleidoscope\Factotum\Http\Controllers\Web'
], function() {

	Route::get('/{uri?}',  'FrontController@index')->where('uri', '.*');
	Route::post('/{uri?}', 'FrontController@index')->where('uri', '.*');

});


<?php


// Route::get('/admin/{uri?}', function () { return redirect('/admin/' ); })->where('uri', '.*');


Route::get('/{uri?}',  '\Kaleidoscope\Factotum\Http\Controllers\Web\FrontController@index')->where('uri', '.*');
Route::post('/{uri?}', '\Kaleidoscope\Factotum\Http\Controllers\Web\FrontController@index')->where('uri', '.*');
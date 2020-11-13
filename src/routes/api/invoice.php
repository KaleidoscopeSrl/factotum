<?php

/**
 *
 *   INVOICES
 *
 */

Route::group([
	'prefix'     => 'invoice',
	'middleware' => 'auth:api',
	'namespace'  => 'Invoice'
], function () {


	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\Invoice'], function() {
		Route::post('/list-paginated',               'ReadController@getListPaginated');
		Route::post('/list-grouped-by-month',        'ReadController@getListGroupedByMonth');
		Route::get('/list',                          'ReadController@getList');
		Route::get('/detail/{id}',                   'ReadController@getDetail');
	});

	Route::group(['middleware' => 'can:delete,Kaleidoscope\Factotum\Invoice,id'], function() {
		Route::delete('/delete/{id}',                'DeleteController@remove');
	});

	Route::group(['middleware' => 'can:read,Kaleidoscope\Factotum\Invoice'], function() {
		Route::post('/generate-pdf-by-month',        'PdfController@generateByMonth');
		Route::get('/view-invoice/{orderId}',        'PdfController@viewInvoiceByOrderId');
	});

});



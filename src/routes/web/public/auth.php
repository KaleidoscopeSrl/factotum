<?php

/**
 * ========================================
 *
 *   AUTH PUBLIC ROUTES
 *
 * ========================================
 */

Route::group([
	'prefix'    => 'auth',
	'namespace' => 'Auth'
], function() {

	// AUTH LOGIN ROUTES
	Route::get('/login',      'AuthController@showLoginForm')->name('login');
	Route::post('/login',     'AuthController@login');

	// PASSWORD RESET ROUTES
	Route::get('/forgot-password',                'ForgotPasswordController@showLinkRequestForm')->name('password.request');
	Route::post('/send-reset-email',              'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('/reset-password/{token}',         'ResetPasswordController@showResetForm')->name('password.reset');
	Route::post('/reset-password',                'ResetPasswordController@reset')->name('password.update');

});
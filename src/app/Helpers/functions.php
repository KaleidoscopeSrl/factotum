<?php

if (!function_exists('auth_user')) {

	/**
	 * @return \Illuminate\Contracts\Auth\Authenticatable|null
	 */
	function auth_user()
	{
		return auth()->user();
	}
}



if (!function_exists('auth_user_role')) {

	/**
	 * @return \Illuminate\Contracts\Auth\Authenticatable|null
	 */
	function auth_user_role()
	{
		return auth_user()->role;
	}
}
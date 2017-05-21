<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\User;

use Kaleidoscope\Factotum\User;

class ReadController extends Controller
{
    public function index()
	{
		return view('factotum::admin.user.list')
					->with('users', User::with('profile')->get() );
	}
}

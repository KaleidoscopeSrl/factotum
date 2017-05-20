<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\User;

use Kaleidoscope\Factotum\User;

class ReadController extends Controller
{
    public function index()
	{
		return view('admin.user.list')
					->with('users', User::with('profile')->get() );
	}

	public function detail($id)
	{
		$user = User::find($id);
		echo '<pre>';print_r($user);die;
	}
}

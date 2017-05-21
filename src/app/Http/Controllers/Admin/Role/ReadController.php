<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Role;

use Kaleidoscope\Factotum\Role;

class ReadController extends Controller
{
	public function index()
	{
		$roles = Role::all();
		return view('factotum::admin.role.list')->with('roles', $roles);
	}
}

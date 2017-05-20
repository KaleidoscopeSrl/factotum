<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Role;

use Kaleidoscope\Factotum\Role;

class ReadController extends Controller
{
	public function index()
	{
		$roles = Role::all();
		return view('admin.role.list')->with('roles', $roles);
	}

	public function detail($id)
	{
		$role = Role::find($id);
		echo '<pre>';print_r($role->toArray());die;
	}
}

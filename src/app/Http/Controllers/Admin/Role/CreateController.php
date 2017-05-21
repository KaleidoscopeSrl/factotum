<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Role;

class CreateController extends Controller
{

	public function create()
	{
		$roles = Role::all();
		return view('factotum::admin.role.edit')
				->with('title', Lang::get('factotum::role.add_new_role') )
				->with('postUrl', url('/admin/role/store') )
				->with('roles', $roles);
	}

	public function store(Request $request)
	{
		$this->validator($request->all())->validate();

		$role = new Role;
		$role = $this->_save( $request, $role );

		return redirect('admin/role/list')->with('message', Lang::get('factotum::role.success_create_role'));
	}

}

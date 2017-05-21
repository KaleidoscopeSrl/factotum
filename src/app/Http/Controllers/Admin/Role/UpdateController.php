<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Role;

class UpdateController extends Controller
{
	public function edit($id)
	{
		$role = Role::find($id);

		return view('factotum::admin.role.edit')
				->with('role', $role)
				->with('title', Lang::get('factotum::role.edit_role'))
				->with('postUrl', url('/admin/role/update/' . $id ) );
	}

	public function update(Request $request, $id)
	{
		$this->validator($request->all(), $id)->validate();

		$role = Role::find($id);
		$this->_save( $request, $role );

		return redirect('admin/role/list')
					->with('message', Lang::get('factotum::role.success_update_role'));
	}
}

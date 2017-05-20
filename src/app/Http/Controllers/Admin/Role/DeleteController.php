<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Role;

use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\Role;
use Kaleidoscope\Factotum\User;

class DeleteController extends Controller
{
	// TODO: reassign role to user with this role.
	public function delete($id)
	{
		User::where('role_id', $id)->delete();
		Role::destroy($id);
		return redirect('/admin/role/list')
					->with('message', Lang::get('factotum::role.success_delete_role'));
	}
}

<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Role;

use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Role;
use Kaleidoscope\Factotum\User;

class DeleteController extends Controller
{
	public function delete($id)
	{
		$role  = Role::find($id);
		$roles = Role::where('id', '<>', $id)->get();
		return view('factotum::admin.role.delete')
					->with('title', Lang::get('factotum::role.delete_role_title') . ' : ' . $role->role)
					->with('roles', $roles);
	}

	public function deleteRole(Request $request, $id)
	{
		$this->validator($request->all())->validate();

		$reassigningRole = $request->input('reassigned_role');

		User::where('role_id', $id)
			->update(['role_id' => $reassigningRole]);

		Role::destroy($id);
		return redirect('/admin/role/list')
					->with('message', Lang::get('factotum::role.success_delete_role'));
	}

	protected function validator( array $data )
	{
		$rules = array(
			'reassigned_role' => 'required',
		);
		return Validator::make($data, $rules);
	}
}

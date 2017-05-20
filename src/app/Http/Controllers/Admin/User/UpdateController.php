<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\User;
use Kaleidoscope\Factotum\Role;

class UpdateController extends Controller
{
	public function edit($id)
	{
		$user = User::find($id);
		$roles = Role::all();

		return view('admin.user.edit')
				->with('user', $user)
				->with('title', Lang::get('factotum::user.edit_user') )
				->with('postUrl', url('/admin/user/update/' . $id ) )
				->with('roles', $roles);
	}

	public function update(Request $request, $id)
	{
		$this->validator($request->all(), $id)->validate();

		$user = User::find($id);
		$profile = $user->profile;

		$this->_save( $request, $user, $profile );

		return redirect('admin/user/list')->with('message', Lang::get('factotum::user.success_update_user'));
	}
}

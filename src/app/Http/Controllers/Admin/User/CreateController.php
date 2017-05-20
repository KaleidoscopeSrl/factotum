<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\User;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Kaleidoscope\Factotum\User;
use Kaleidoscope\Factotum\Role;
use Kaleidoscope\Factotum\Profile;

class CreateController extends Controller
{
	public function create()
	{
		$roles = Role::all();
		return view('admin.user.edit')
					->with('title', Lang::get('factotum::user.add_new_user') )
					->with('postUrl', url('/admin/user/store') )
					->with('roles', $roles);
	}

	public function store(Request $request)
	{
		$this->validator($request->all())->validate();

		$user = new User;
		$user->editable = true;
		$profile = new Profile;
		$user = $this->_save( $request, $user, $profile );

		event(new Registered($user));

		return redirect('admin/user/list')
					->with('message', Lang::get('factotum::user.success_create_user'));
	}

}

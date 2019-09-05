<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RedirectsUsers;

use Illuminate\Support\Facades\Validator;

use Kaleidoscope\Factotum\Http\Controllers\Api\Controller;
use Kaleidoscope\Factotum\User;
use Kaleidoscope\Factotum\Profile;
use Kaleidoscope\Factotum\Role;

class RegisterController extends Controller
{
	use RedirectsUsers;

	protected $redirectTo = '/admin/auth/login';

	public function index()
	{
		$roles = Role::all();
		return view('factotum::admin.user.register')->with('roles', $roles);
	}

	public function register(Request $request)
	{
		$data = $request->all();
		$subscriberRole = Role::whereRole('subscriber')->first();
		$data['role_id'] = $subscriberRole->id;
		$this->validator($data)->validate();
		event(new Registered($user = $this->create($data)));
		//$this->guard()->login($user);
		return redirect($this->redirectPath());
	}


	protected function validator(array $data)
	{
		return Validator::make($data, [
			'first_name'     => 'required|max:64',
			'last_name'      => 'required|max:64',
			'role_id'        => 'required',
			'email'          => 'required|email|max:128|unique:users',
			'password'       => 'required|min:6|confirmed',
		]);
	}

	protected function create(array $data)
	{
		$user = User::create([
			'email'    => $data['email'],
			'password' => bcrypt($data['password']),
			'role_id'  => $data['role_id']
		]);

		Profile::create([
			'first_name' => $data['first_name'],
			'last_name'  => $data['last_name'],
			'user_id'    => $user->id
		]);
		return $user;
	}

}

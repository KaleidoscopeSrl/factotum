<?php

namespace Kaleidoscope\Factotum\Http\Requests;

use Illuminate\Support\Facades\Hash;

use Kaleidoscope\Factotum\Role;

class RegisterUser extends CustomFormRequest
{

	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		$rules = [
			'first_name'     => 'required|max:64',
			'last_name'      => 'required|max:64',
			'email'          => 'required|email|max:128|unique:users,email',
			'password'       => 'required|string|min:8|confirmed',

			'privacy'          => 'required',
			'terms_conditions' => 'required'
		];


		$data = $this->all();

		if ( isset($data['password']) && $data['password'] != '' ) {
			$data['password'] = Hash::make($data['password']);
		}

		if ( !isset($data['role_id']) ) {
			$customerRole    = Role::where( 'role', 'customer' )->first();
			$data['role_id'] = $customerRole->id;
		}

		$this->merge($data);

		return $rules;
	}

}

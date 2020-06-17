<?php

namespace Kaleidoscope\Factotum\Http\Requests;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UpdateUser extends CustomFormRequest
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
			'email'          => 'required|email|max:128',
		];

		$data = $this->all();
		$user = Auth::user();

		if ( $user->email != $data['email'] ) {
			$rules['email'] = 'required|email|max:128|unique:users,id,' . $user->id;
		}

		if ( isset($data['password']) && $data['password'] != '' ) {
			$rules['password'] = 'required|string|min:8|confirmed';
			$data['password']  = Hash::make($data['password']);
		}

		$this->merge($data);

		return $rules;
	}

}

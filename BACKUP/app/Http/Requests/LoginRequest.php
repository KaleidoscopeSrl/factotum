<?php

namespace Kaleidoscope\Factotum\Http\Requests;


class LoginRequest extends CustomFormRequest
{


	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		return [
			'email'     => 'required|email',
			'password'  => 'required|string|min:8',
		];
	}
	
}

<?php

namespace Kaleidoscope\Factotum\Http\Requests;


class DeleteUser extends CustomFormRequest
{

	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		$rules = [
			'reassigned_user' => 'required',
		];

		return $rules;
	}



}

<?php

namespace Kaleidoscope\Factotum\Http\Requests;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UpdateDeliveryAddress extends CustomFormRequest
{

	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		$rules = [
			'delivery_address'     => 'required',
			'delivery_zip'         => 'required|max:7',
			'delivery_city'        => 'required',
			'delivery_province'    => 'required',
			'delivery_nation'      => 'required|max:2',
		];

		return $rules;
	}

}

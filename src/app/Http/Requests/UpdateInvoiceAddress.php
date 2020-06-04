<?php

namespace Kaleidoscope\Factotum\Http\Requests;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UpdateInvoiceAddress extends CustomFormRequest
{

	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		$rules = [
			'invoice_address'     => 'required',
			'invoice_zip'         => 'required|max:7',
			'invoice_city'        => 'required',
			'invoice_province'    => 'required',
			'invoice_nation'      => 'required|max:2',
		];

		return $rules;
	}

}

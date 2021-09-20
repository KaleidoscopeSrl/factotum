<?php

namespace Kaleidoscope\Factotum\Http\Requests;


class StoreTax extends CustomFormRequest
{

	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		$rules = [
			'name'     => 'required',
			'amount'   => 'required',
		];

		$data = $this->all();

		$this->merge($data);

		return $rules;
	}


}

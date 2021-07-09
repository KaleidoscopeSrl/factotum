<?php

namespace Kaleidoscope\Factotum\Http\Requests;


class StoreProductAttribute extends CustomFormRequest
{

	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		$rules = [
			'label' => 'required',
			'name'  => 'required|unique:product_attributes,name',
		];

		return $rules;
	}

}

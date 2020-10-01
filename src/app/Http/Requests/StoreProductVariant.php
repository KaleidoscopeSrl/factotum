<?php

namespace Kaleidoscope\Factotum\Http\Requests;


class StoreProductVariant extends CustomFormRequest
{

	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		$rules = [
			'label'       => 'required',
			'quantity'    => 'required',
			'product_id'  => 'required',
		];

		return $rules;
	}

}

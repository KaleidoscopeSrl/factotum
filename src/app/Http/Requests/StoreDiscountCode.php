<?php

namespace Kaleidoscope\Factotum\Http\Requests;


class StoreDiscountCode extends CustomFormRequest
{

	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		$rules = [
			'code'        => 'required|alpha_num|unique:discount_codes,code',
			'discount'    => 'required|numeric',
			'amount'      => 'required|numeric',
			'type'        => 'required',
			'customer_id' => 'required_if:all_customers,false',
			'products'    => 'required',
		];

		$id = request()->route('id');

		if ( $id ) {
			$rules['code'] = 'required|alpha_num|unique:discount_codes,id,' . $id;
		}

		return $rules;
	}

}

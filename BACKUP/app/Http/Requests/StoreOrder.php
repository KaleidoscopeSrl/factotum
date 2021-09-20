<?php

namespace Kaleidoscope\Factotum\Http\Requests;


class StoreOrder extends CustomFormRequest
{

	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		$rules = [
			'customer_id'       => 'required|exists:users,id',
			'status'            => 'required',

			'delivery_address'  => 'required',
			'delivery_city'     => 'required',
			'delivery_zip'      => 'required|max:7',
			'delivery_province' => 'required|max:2',
			'delivery_nation'   => 'required|max:2',

			'invoice_address'  => 'required',
			'invoice_city'     => 'required',
			'invoice_zip'      => 'required|max:7',
			'invoice_province' => 'required|max:2',
			'invoice_nation'   => 'required|max:2',

			'products'         => 'required|array|min:1'
		];

		$data = $this->all();

		$this->merge($data);

		return $rules;
	}


}

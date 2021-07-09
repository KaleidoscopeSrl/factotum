<?php

namespace Kaleidoscope\Factotum\Http\Requests;


class SearchProduct extends CustomFormRequest
{

	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		$rules = [
			'term' => 'required|min:3'
		];

		$data = $this->all();

		if ( isset($data['product_category_id']) && $data['product_category_id'] != '' ) {
			$rules['product_category_id'] = 'required|exists:product_categories,id';
			unset($rules['term']);
		}

		return $rules;
	}

}

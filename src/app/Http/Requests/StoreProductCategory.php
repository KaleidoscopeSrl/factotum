<?php

namespace Kaleidoscope\Factotum\Http\Requests;


class StoreProductCategory extends CustomFormRequest
{

	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		$rules = [
			'label' => 'required|max:255',
			'name'  => 'required|max:50|unique:product_categories',
		];

		$data = $this->all();

		$id = request()->route('id');

		if ( $id ) {
			$rules['name'] = 'required|unique:product_categories,name,' . $id;
		}

		$this->merge($data);

		return $rules;
	}


}

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
		$rules = [];
		$data  = $this->all();

		$productCategoriesViaPim = config('factotum.product_categories_via_pim');

		if ( !$productCategoriesViaPim ) {

			$rules = [
				'label' => 'required|max:255',
				'name'  => 'required|max:50|unique:product_categories',
			];

			$id = request()->route('id');

			if ( $id ) {
				$rules['name'] = 'required|unique:product_categories,name,' . $id;
			}

		}

		$this->merge($data);

		return $rules;
	}


}

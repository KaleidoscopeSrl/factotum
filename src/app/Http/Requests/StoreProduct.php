<?php

namespace Kaleidoscope\Factotum\Http\Requests;


class StoreProduct extends CustomFormRequest
{

	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		$rules = [
			'url' => 'required'
		];

		$data  = $this->all();

		$productsViaPim = config('factotum.products_via_pim');

		if ( !$productsViaPim ) {

			$rules = [
				'code'                 => 'required|max:16|unique:products,code',
				'name'                 => 'required|max:128',
				'basic_price'          => 'required|numeric',
				'brand_id'             => 'required',
				'product_category_id'  => 'required',
			];

			if ( isset($data['image']) && $data['image'] != '' ) {
				$rules['image'] = 'required';
			}

			$id = request()->route('id');

			if ( $id ) {
				$rules['code'] = 'required|max:16|unique:products,id,' . $id;
			}

		}

		$this->merge($data);

		return $rules;
	}


}

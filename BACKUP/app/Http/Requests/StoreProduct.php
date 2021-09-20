<?php

namespace Kaleidoscope\Factotum\Http\Requests;

use Illuminate\Validation\Rule;

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

		$data = $this->all();

		$productsViaPim = config('factotum.products_via_pim');

		if ( !$productsViaPim ) {

			$rules = [
				'code'                 => 'required|max:16|unique:products,code,lang',
				'name'                 => 'required|max:128',
				'basic_price'          => 'required|numeric',
			];

			if ( isset($data['image']) && $data['image'] != '' ) {
				$rules['image'] = 'required';
			}

			$id = request()->route('id');

			if ( $id ) {
				$rules['code'] = [
					'required',
					'max:16',
					Rule::unique('products', 'code')->ignore($id)->where('lang', '<>', request()->input('lang') ),
				];
			}

		}

		$this->merge($data);

		if ( !$data['has_variants'] ) {
			$rules['quantity'] = 'required|numeric';
		}


		return $rules;
	}


}

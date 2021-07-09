<?php

namespace Kaleidoscope\Factotum\Http\Requests;

use Illuminate\Validation\Rule;

class StoreProductAttributeValue extends CustomFormRequest
{

	public function authorize()
	{
		return true;
	}


	public function rules()
	{
		$productAttributeId = request()->input('product_attribute_id');
		$name               = request()->input('name');

		$id = request()->input('id');

		$rules = [
			'product_attribute_id'  => 'required|exists:product_attributes,id',
			'label'                 => 'required',
		];

		$nameUniqueRule = Rule::unique('product_attribute_values')->where(function ($query) use($productAttributeId, $name) {
			return $query->where('product_attribute_id', $productAttributeId)->where('name', $name);
		});

		if ( $id ) {
			$nameUniqueRule->ignore($id);
		}

		$rules['name'] = [
			'required',
			$nameUniqueRule
		];

		return $rules;
	}

}

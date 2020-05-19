<?php

namespace Kaleidoscope\Factotum\Http\Requests;


class StoreProduct extends CustomFormRequest
{

	public function authorize()
	{
		return true;
	}


	protected function getValidatorInstance()
	{
		$data = $this->all();

		if ( isset($data['image']) && $data['image'] == 'null' ) {
			$data['image'] = null;
		}


		if ( isset($data['active']) && $data['active'] == '' ) {
			$data['active'] = 0;
		}

		$this->merge($data);

		return parent::getValidatorInstance();
	}


	public function rules()
	{
		$rules = [
			'code'            => 'required|max:16|unique:products,code',
			'name'            => 'required|max:128',
			'price'           => 'required|numeric',
			'brand_id'        => 'required',
			'category_id'     => 'required',
		];

		$data = $this->all();

		if ( isset($data['image']) && $data['image'] != '' ) {
			$rules['image'] = 'required';
		}

		if ( isset($data['validity']) && $data['validity'] != '' ) {
			$rules['validity'] = 'date';
		}


		$id = request()->route('id');

		if ( $id ) {
			$rules['code'] = 'required|max:16|unique:products,id,' . $id;
		}

		$this->merge($data);

		return $rules;
	}


}

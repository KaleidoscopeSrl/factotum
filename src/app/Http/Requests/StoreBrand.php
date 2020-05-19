<?php

namespace Kaleidoscope\Factotum\Http\Requests;


class StoreBrand extends CustomFormRequest
{

	public function authorize()
	{
		return true;
	}


	protected function getValidatorInstance()
	{
		$data = $this->all();

		if ( isset($data['logo']) && $data['logo'] == 'null' ) {
			$data['logo'] = null;
		}

		$this->merge($data);

		return parent::getValidatorInstance();
	}


	public function rules()
	{
		$rules = [
			'code' => 'required|max:8|unique:brands',
			'name' => 'required|max:50',
		];

		$data = $this->all();

		if ( isset($data['logo']) && $data['logo'] != '' ) {
			$rules['logo'] = 'required';
		}

		$id = request()->route('id');

		if ( $id ) {
			$rules['code'] = 'required|unique:brands,code,' . $id;
		}

		$this->merge($data);

		return $rules;
	}


}

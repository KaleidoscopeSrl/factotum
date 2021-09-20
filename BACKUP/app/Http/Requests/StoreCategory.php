<?php

namespace Kaleidoscope\Factotum\Http\Requests;


class StoreCategory extends CustomFormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
			'label' => 'required|max:255',
			'name'  => 'required|max:50|unique:categories',
		];

		$data = $this->all();

		$id = request()->route('id');

		if ( $id ) {
			$rules['name'] = 'required|unique:categories,name,' . $id;
		}

		$this->merge($data);

		return $rules;
	}


}

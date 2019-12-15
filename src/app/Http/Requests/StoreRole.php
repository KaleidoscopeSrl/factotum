<?php

namespace Kaleidoscope\Factotum\Http\Requests;


class StoreRole extends CustomFormRequest
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
			'role' => 'required|max:32|unique:roles',
		];

		$data = $this->all();

		$id = request()->route('id');

		if ( $id ) {
			$rules['role'] = 'required|unique:roles,role,' . $id;
		}

		$this->merge($data);

		return $rules;
	}


}

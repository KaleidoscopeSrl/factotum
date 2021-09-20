<?php

namespace Kaleidoscope\Factotum\Http\Requests;

use Kaleidoscope\Factotum\Models\Capability;


class StoreCapability extends CustomFormRequest
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
			'content_type_id' => 'required',
			'role_id'         => 'required'
		];

		$data = $this->all();

		$id            = request()->route('id');
		$contentTypeId = request()->input('content_type_id');
		$roleId        = request()->input('role_id');

		if ( $contentTypeId && $roleId ) {

			if ( $id ) {
				$capability = Capability::where( 'role_id',         $roleId )
										->where( 'content_type_id', $contentTypeId )
										->first();

				if ( $capability && $capability->id != $id ) {
					$rules['role_id'] = 'required|unique:capabilities,role_id,NULL,id,content_type_id,' . $contentTypeId;
				}

			} else {
				$rules['role_id'] = 'required|unique:capabilities,role_id,NULL,id,content_type_id,' . $contentTypeId;
			}

		}

		$this->merge($data);

		return $rules;
	}


}

<?php

namespace Kaleidoscope\Factotum\Http\Requests;

use Kaleidoscope\Factotum\Content;
use Kaleidoscope\Factotum\ContentField;

class StoreContentField extends CustomFormRequest
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
			'label'           => 'required',
			'name'            => 'required|not_in:' . join(',', config('factotum.prohibited_content_field_names')),
			'type'            => 'required',

			'options'         => 'required_if:type,select,multiselect,checkbox,radio',

			'max_file_size'   => 'required_if:type,file_upload,image_upload,gallery',
			'allowed_types'   => 'required_if:type,file_upload,image_upload,gallery',

			'min_width_size'  => 'required_if:type,image_upload,gallery',
			'min_height_size' => 'required_if:type,image_upload,gallery',
			'image_operation' => 'required_if:type,image_upload,gallery',

		];

		$data = $this->all();

		$id            = request()->route('id');
		$name          = request()->input('name');
		$contentTypeId = request()->input('content_type_id');

		if ( in_array( $data['type'], [ 'file_upload', 'image_upload', 'gallery' ] ) ) {
			$rules['max_file_size']   .= '|numeric';
			$rules['allowed_types']   .= '|allowed_types';
		}

		if ( in_array( $data['type'], [ 'image_upload', 'gallery' ] ) ) {
			$rules['min_width_size']  .= '|numeric';
			$rules['min_height_size'] .= '|numeric';
		}


		if ( $id ) {

			$contentField = ContentField::where( 'name',            $name )
										->where( 'content_type_id', $contentTypeId )
										->first();

			if ( $contentField && $contentField->id != $id ) {
				$rules['name'] .= '|unique:content_fields,name,NULL,id,content_type_id,' . $contentTypeId;
			}

		} else {

			$rules['name'] .= '|unique:content_fields,name,NULL,id,content_type_id,' . $contentTypeId;

		}

		$this->merge($data);

		return $rules;
	}


	protected function getValidatorInstance()
	{
		$data = $this->all();

		$id = request()->route('id');

		if ( isset($data['options']) && $data['options'] ) {
			$data['options'] = json_encode( $data['options'] );
		} else {
			$data['options'] = null;
		}

		if ( isset($data['allowed_types']) && $data['allowed_types'] ) {
			$data['allowed_types'] = json_encode( $data['allowed_types'] );
		} else {
			$data['allowed_types'] = null;
		}

		if ( isset($data['resizes']) && $data['resizes'] ) {
			$data['resizes'] = json_encode( $data['resizes'] );
		} else {
			$data['resizes'] = null;
		}

		if ( isset($data['rules']) && $data['rules'] ) {
			$data['rules'] = json_encode( $data['rules'] );
		} else {
			$data['rules'] = null;
		}

		if ( $id ) {
			$contentField              = ContentField::find($id);
			$data['old_content_field'] = $contentField->name;
		}

		$this->merge($data);

		return parent::getValidatorInstance();
	}

}

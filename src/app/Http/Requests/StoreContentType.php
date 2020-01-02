<?php

namespace Kaleidoscope\Factotum\Http\Requests;

use Kaleidoscope\Factotum\ContentType;

class StoreContentType extends CustomFormRequest
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
			'content_type' => 'required|max:32|unique:content_types|not_in:' . join(',', config('factotum.prohibited_content_types') ),
		];

		$data = $this->all();

		$id = request()->route('id');

		if ( $id ) {
			$rules['content_type'] = 'required|max:32|not_in:' . join(',', config('factotum.prohibited_content_types') )
									. '|unique:content_types,content_type,' . $id;
		}

		$this->merge($data);

		return $rules;
	}


	protected function getValidatorInstance()
	{
		$data = $this->all();

		$data['content_type'] = $this->createSlug( $data['content_type'] );

		$id = request()->route('id');

		if ( $id ) {
			$contentType = ContentType::find($id);
			$data['old_content_type'] = $contentType->content_type;
		}

		$this->merge($data);

		return parent::getValidatorInstance();
	}


	private function createSlug($str, $delimiter = '_'){

		$slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
		return $slug;

	}

}

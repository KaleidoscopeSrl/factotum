<?php

namespace Kaleidoscope\Factotum\Http\Requests;


use Kaleidoscope\Factotum\ContentField;
use Kaleidoscope\Factotum\Media;

class StoreMedia extends CustomFormRequest
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

	protected function getValidatorInstance()
	{
		$data = $this->all();

		// TODO: multilanguage
		$data['lang'] = 'it';
//      $data['lang'] = $request->session()->get('currentLanguage');

		$file = request()->file('files');

		$data['filename'] = $file->getClientOriginalName();
		$data['filename'] = Media::filenameAvailable( $data['filename'] );

		// TODO: Auth::user()->id;
		$data['user_id'] = 1;
		$data['mime_type'] = $file->getMimeType();

		if ( str_contains( $data['mime_type'], 'image/' )  ) {
			$imageSize = getimagesize( $file->path() );

			$data['width']  = $imageSize[0];
			$data['height'] = $imageSize[1];
		}

		$data['size'] = filesize( $file->path() );

		$this->merge($data);

		return parent::getValidatorInstance();
	}

}

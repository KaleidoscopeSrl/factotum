<?php

namespace Kaleidoscope\Factotum\Http\Requests;

use Illuminate\Support\Str;

use Kaleidoscope\Factotum\Models\Media;


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
		$rules = [];

		$id = request()->route('id');

		if ( $id ) {
			$rules['filename'] = 'required|unique:media,filename,' . $id;
		}

		return $rules;
	}

	protected function getValidatorInstance()
	{
		$data = $this->all();

		$file = request()->file('files');

		$data['mime_type'] = $file->getMimeType();
		$data['filename']  = $file->getClientOriginalName();
		$data['filename']  = Media::filenameAvailable( $data['filename'] );

		$webpFilename = substr( $data['filename'],0 , strlen($data['filename']) - 3 );
		$data['filename_webp'] = $webpFilename . 'webp';

		if ( Str::contains( $data['mime_type'], 'image/' )  ) {
			$imageSize = getimagesize( $file->path() );

			$data['width']  = $imageSize[0];
			$data['height'] = $imageSize[1];
		}

		$data['size'] = filesize( $file->path() );

		$this->merge($data);

		return parent::getValidatorInstance();
	}

}

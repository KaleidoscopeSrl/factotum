<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Media;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Kaleidoscope\Factotum\Http\Controllers\Admin\Controller as MainAdminController;
use Kaleidoscope\Factotum\Media;
use Kaleidoscope\Factotum\ContentField;


class Controller extends MainAdminController
{
	protected $_limit = 12;

	protected function _getField($fieldName)
	{
		$field = null;
		if ( $fieldName != 'undefined' ) {
			if ( $fieldName == 'fb_image' ) {
				$field = new \stdClass();
				$field->name            = 'fb_image';
				$field->type            = 'image_upload';
				$field->mandatory       = false;
				$field->image_operation = 'fit';
				$field->max_file_size   = 2000;
				$field->allowed_types   = '.jpg,.png';
				$field->min_width_size  = 200;
				$field->min_height_size = 200;
				$field->image_bw        = false;
				$field->resizes         = null;
			} else {
				$field = ContentField::whereName($fieldName)->first();
			}
		}

		return $field;
	}

	protected function _save( Request $request, $media )
	{
		$data = $request->all();

		$media->caption     = $data['caption'];
		$media->alt_text    = $data['alt_text'];
		$media->description = $data['description'];
		$media->save();
		return $media;
	}

	protected function validator( Request $request, array $data )
	{
		$rules = array();
		return Validator::make($data, $rules);
	}

	protected function _getMediaPaginated( $offset, $allowedTypes )
	{
		if ( $allowedTypes != '*' ) {

			$allowedTypes = explode(',', $allowedTypes);
			$tmp = [];

			foreach ( $allowedTypes as $at ) {
				$tmp[] = \GuzzleHttp\Psr7\mimetype_from_extension( $at );
			}

			return Media::whereIn( 'mime_type', $tmp )
						->take($this->_limit)->skip($offset)
						->orderBy('id', 'desc')->get();

		} else {
			return Media::take($this->_limit)->skip($offset)
						->orderBy('id', 'desc')->get();
		}
	}

	protected function _getImagesPaginated( $offset )
	{
		return Media::whereIn( 'mime_type', [ 'image/jpeg', 'image/png', 'image/gif' ] )
					->take($this->_limit)->skip($offset)
					->orderBy('id', 'desc')->get();
	}

}

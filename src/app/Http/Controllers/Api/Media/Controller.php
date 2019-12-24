<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Media;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Kaleidoscope\Factotum\Http\Controllers\Api\Controller as ApiBaseController;
use Kaleidoscope\Factotum\Media;
use Kaleidoscope\Factotum\ContentField;


class Controller extends ApiBaseController
{
	protected $_limit = 12;


	// TODO: Non metto limiti al caricamento dell'immagine

//	protected function _getField($fieldName)
//	{
//		$field = null;
//		if ( $fieldName != 'undefined' ) {
//			if ( $fieldName == 'fb_image' ) {
//				$field = new \stdClass();
//				$field->name            = 'fb_image';
//				$field->type            = 'image_upload';
//				$field->mandatory       = false;
//				$field->image_operation = 'fit';
//				$field->max_file_size   = 2000;
//				$field->allowed_types   = '.jpg,.png';
//				$field->min_width_size  = 100;
//				$field->min_height_size = 100;
//				$field->image_bw        = false;
//				$field->resizes         = null;
//			} else {
//				$field = ContentField::whereName($fieldName)->first();
//			}
//		}
//
//		return $field;
//	}

	protected function _save( Request $request, $media )
	{
		$data = $request->all();

		$media->caption     = $data['caption'];
		$media->alt_text    = $data['alt_text'];
		$media->description = $data['description'];

		if ( isset($data['filename']) && $data['filename'] != pathinfo($media->filename, PATHINFO_FILENAME) ){
            $tmpUrl = $media->url;
            $tmpUrl = explode('/', $tmpUrl);
            $tmpUrl[count($tmpUrl)-1] = $data['filename'] . '.' . pathinfo($media->filename, PATHINFO_EXTENSION);
            $tmpUrl = implode('/', $tmpUrl);
            if( file_exists($media->url) ){
                if (rename($media->url,$tmpUrl)){
                    $media->url = $tmpUrl;
                    $media->filename = $data['filename'] . '.' . pathinfo($media->filename, PATHINFO_EXTENSION);
                }
            }
        }

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

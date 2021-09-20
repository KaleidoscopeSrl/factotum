<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Media;

use Kaleidoscope\Factotum\Library\Utility;
use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;


class Controller extends ApiBaseController
{

	protected function _parseMedia($media, $fieldName = null)
	{
		if ( $media ) {

			$tmp = [
				'id'         => $media->id,
				'url'        => $media->url,
				'thumb'      => $media->thumb,
				'filename'   => $media['filename'],
				'size'       => Utility::formatBytes( $media->size ),
				'updated_at' => $media->updated_at
			];


			if ( isset($fieldName) && !is_numeric($fieldName) ) {
				$tmp['field_id'] = $fieldName;
			}

			return $tmp;

		}
	}

}

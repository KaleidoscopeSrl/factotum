<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Media;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;

use Kaleidoscope\Factotum\Media;

class DeleteController extends Controller
{
	public function remove(Request $request, $mediaID)
	{

		$media = Media::find($mediaID);

		$this->_removeMedia($media);

		return response()->json(array('result' => 'ok'));

	}

	private function _removeMedia($media)
	{
		if ( $media ) {
			Storage::deleteDirectory( 'media/' . $media->id );
			return Media::destroy( $media->id );
		}
	}
}

<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Media;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;

use Kaleidoscope\Factotum\Media;

class DeleteController extends Controller
{
	public function delete(Request $request, $mediaID = null)
	{
		$method = $request->method();

		if ( $request->method() == 'POST' ) {
			$mediaID = $request->input('id');
		}

		if ( $mediaID ) {
			$media = Media::find($mediaID);
		} else if ( $request->input('filename') != '' ) {
			$media = Media::whereFilename( $request->input('filename') )->first();
		}
		$this->_removeMedia($media);

		if ( $request->method() == 'POST' ) {
			return response()->json(array('result' => 'ok'));
		} else {
			$page = $request->input('page');
			return redirect( '/admin/media/list/' . (isset($page) ? '?page=' . $page : '') )
						->with('message', Lang::get('factotum::media.success_delete_media'));
		}
	}

	private function _removeMedia($media)
	{
		Storage::deleteDirectory( 'media/' . $media->id );
		return Media::destroy( $media->id );
	}
}

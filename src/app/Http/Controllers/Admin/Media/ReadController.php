<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Media;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Kaleidoscope\Factotum\ContentField;
use Kaleidoscope\Factotum\Media;

class ReadController extends Controller
{

	public function index()
	{
		$media = DB::table('media')
				   ->paginate(25);
		return view('factotum::admin.media.list')->with('media', $media);
	}


	public function getImages()
	{
		$images = Media::where( 'mime_type', '=', 'image/jpeg' )
						->orWhere( 'mime_type', '=', 'image/png' )
						->orWhere( 'mime_type', '=', 'image/gif' )
						->get()
						->toArray();


		return response()->json( $this->_parseMedia($images) );
	}


	public function getMediaPaginated(Request $request)
	{
		$offset    = $request->input('offset');
		$fieldName = $request->input('field_name', null);

		$field = $this->_getField( $fieldName );

		if ( $field->type == 'image_upload' || $field->type == 'gallery' ) {
			$media = $this->_getImagesPaginated( $offset );
		} else {
			$media = $this->_getMediaPaginated( $offset );
		}

		foreach ( $media as $i => $m ) {
			$media[$i] = $this->_parseMedia( $m, $fieldName );
		}

		return response()->json( $media );

	}

}


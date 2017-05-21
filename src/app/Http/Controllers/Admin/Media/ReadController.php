<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Media;

use Illuminate\Support\Facades\DB;

use Kaleidoscope\Factotum\Media;

class ReadController extends Controller
{

	public function index()
	{
		$media = DB::table('media')->paginate(25);
		return view('factotum::admin.media.list')->with('media', $media);
	}


	public function getImages()
	{
		$images = Media::where( 'mime_type', '=', 'image/jpeg' )
						->orWhere( 'mime_type', '=', 'image/png' )
						->orWhere( 'mime_type', '=', 'image/gif' )
						->get()
						->toArray();

		$tmp = array();
		if ( count($images) > 0 ) {
			foreach ( $images as $file ) {
				$tmp[] = array(
					'id'    => $file['id'],
					'url'   => url( $file['url'] ),
					'thumb' => url( $file['url'] ),
					'name'  => $file['filename']
				);
			}
		}
		return response()->json($tmp);
	}

}


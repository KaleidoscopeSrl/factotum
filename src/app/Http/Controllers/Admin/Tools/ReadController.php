<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\Tools;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\ContentField;
use Kaleidoscope\Factotum\Media;

class ReadController extends Controller
{

	public function index()
	{
		return view('factotum::admin.tools.list');
	}

	public function resizeMedia( Request $request )
	{
		$thumbSize = config('factotum.factotum.thumb_size');
		$contentFieldsImages = ContentField::whereIn( 'type', array( 'image_upload', 'gallery' ) )->get()->toArray();

		$resizes = array();
		$resizes[] = $thumbSize['width'] . ':' . $thumbSize['height'];
		if ( count($contentFieldsImages) > 0 ) {
			foreach ( $contentFieldsImages as $contentField ) {
				$tmp = explode( ';', $contentField['resizes'] );
				$resizes = array_merge( $resizes, $tmp );
			}
		}
		$resizes = array_unique( $resizes );

		$skip = $request->input('skip');
		if ( $skip ) {
			$skip = 0;
		}

		$totalMedia = Media::whereIn( 'mime_type', array( 'image/jpeg', 'image/png', 'image/gif' ))->count();

		$media = Media::whereIn( 'mime_type', array( 'image/jpeg', 'image/png', 'image/gif' ))
						->skip( $skip )
						->get();

		return response()->json( [ 'status' => 'ok', 'resizes' => $resizes, 'media' => $media ]);
	}

	private function send_message($id, $message, $progress)
	{
		$d = array('message' => $message , 'progress' => $progress);

		echo "id: $id" . PHP_EOL;
		echo "data: " . json_encode($d) . PHP_EOL;
		echo PHP_EOL;

		// PUSH THE data out by all FORCE POSSIBLE
		ob_flush();
		flush();
	}
}

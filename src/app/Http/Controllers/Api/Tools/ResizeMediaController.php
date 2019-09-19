<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Tools;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Kaleidoscope\Factotum\ContentField;
use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\Media;

class ResizeMediaController extends Controller
{

	public function index()
	{
		return view('factotum::admin.tools.resize_media')
					->with( 'title', 'Resize Media' )
					->with( 'postUrl', url('/admin/tools/do-resize-media') );
	}

	public function resize( Request $request )
	{
		if ( $request->method() == 'POST' ) {
			$media = Media::whereIn( 'mime_type', array( 'image/jpeg', 'image/png', 'image/gif' ))->get();

			$ids = array();
			foreach ( $media as $image ) {
				$ids[] = $image->id;
			}
			$ids = join( ',', $ids );
			return view('factotum::admin.tools.do_resize_media')
						->with( 'resizableMedia', $ids )
						->with( 'count', $media->count() );
		} else {
			return redirect('admin/tools/resize-media');
		}
	}

	public function resizeMedia( Request $request )
	{

		$startTime = microtime(true);

		$contentTypeId = $request->input('contentTypeId');

		$contentType = ContentType::find($contentTypeId);

		$contentFieldsImages = ContentField::whereIn( 'type', array( 'image_upload', 'gallery' ) )->where('content_type_id', $contentTypeId)->get();

		$thumbSize = config('factotum.factotum.thumb_size');

		$resizes = array();
		$resizes[] = $thumbSize['width'] . ':' . $thumbSize['height'];

		$resizes = array_unique( $resizes );

		@error_reporting( 0 ); // Don't break the JSON result

		foreach ( $contentFieldsImages as $contentFieldsImage ) {

			$tmpImages = DB::table( $contentType->content_type )->pluck( $contentFieldsImage->name )->all();

			foreach ( $tmpImages as $mediaID ) {

				if ( !$mediaID || $mediaID == "" ){
					continue;
				}

				$media = Media::find( $mediaID );

				if ( $media && !Storage::disk('local')->exists( $media->url ) ) {
					return response()->json( [ 'status' => 'ko', 'error' => 'The originally uploaded image file cannot be found.' ], 400 );
				}

				// 5 minutes per image should be PLENTY
				@set_time_limit( 900 );

				Media::saveImage( $contentFieldsImage, $media->url );

			}

		}
		$endTime = microtime(true);

		return response()->json( [
			'status'   => 'ok',
//			'id'       => $mediaID,
//			'filename' => $media->filename,
			'time'     => round( $endTime - $startTime, 2 )
		]);
	}

}

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

	public function getResize( Request $request )
	{

		$contentTypeId = $request->input('contentTypeId');

		$contentType = ContentType::find($contentTypeId);

		$contentFieldsImages = ContentField::whereIn( 'type', array( 'image_upload', 'gallery' ) )->where('content_type_id', $contentTypeId)->get();

		$mediaList = [];

		foreach ( $contentFieldsImages as $contentFieldsImage ) {

			$tmpImages = DB::table($contentType->content_type)->pluck($contentFieldsImage->name)->all();

			foreach ( $tmpImages as $mediaID ) {

				if ( !$mediaID || $mediaID == '' ) {
					continue;
				}

				if ( isset($mediaList[$mediaID] ) ) {

					if ( !in_array( $contentFieldsImage->id,$mediaList[$mediaID] ) ) {
						$mediaList[$mediaID][] = $contentFieldsImage->id;
					}

				} else {
					$mediaList[$mediaID] = [ $contentFieldsImage->id ];
				}

			}

		}

		return response()->json( [ 'result'   => 'ok', 'mediaFields'    => $mediaList ] );

	}

	public function resizeMedia( Request $request )
	{

		$startTime = microtime(true);

		$mediaId        = $request->input('mediaId');
		$media          = Media::find( $mediaId );

		$contentFieldIds  = $request->input('contentFieldIds');

		$thumbSize = config('factotum.thumb_size');

		$resizes = array();
		$resizes[] = $thumbSize['width'] . ':' . $thumbSize['height'];

		$resizes = array_unique( $resizes );

		@error_reporting( 0 ); // Don't break the JSON result

		foreach ( $contentFieldIds as $contentFieldId ) {

			$contentField = ContentField::find( $contentFieldId );

			if ( $media && !Storage::disk('local')->exists( $media->url ) ) {
				return response()->json( [ 'result' => 'ko', 'error' => 'The originally uploaded image file cannot be found.' ], 400 );
			}

			@set_time_limit( 900 );
			Media::saveImage( $contentField, $media->url );

		}

		$endTime = microtime(true);

		return response()->json( [
			'result'   => 'ok',
			'id'       => $mediaId,
			'filename' => $media->filename,
			'time'     => round( $endTime - $startTime, 2 )
		]);
	}

}

<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Tools;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Models\ContentField;
use Kaleidoscope\Factotum\Models\ContentType;
use Kaleidoscope\Factotum\Models\Media;



class ResizeMediaController extends ApiBaseController
{

	public function getResize( Request $request )
	{
		$contentTypeId = $request->input('contentTypeId');

		if ( $contentTypeId === 'all' ) {

			$mediaList = [];

			$media = Media::all();

			foreach ( $media as $m ) {
				$mediaList[$m->id][] = $m->id;
			}

			return response()->json( [ 'result'   => 'ok', 'mediaFields'    => $mediaList ] );

		}

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


	public function doResize( Request $request )
	{
		$startTime        = microtime(true);
		$mediaId          = $request->input('mediaId');
		$contentFieldIds  = $request->input('contentFieldIds');
		$media            = Media::find( $mediaId );

		// Don't break the JSON result
		@error_reporting( 0 );

		foreach ( $contentFieldIds as $contentFieldId ) {
			$contentField = ContentField::find( $contentFieldId );

			if ( $media && !Storage::disk('media')->exists( $media->id . '/' . $media->filename ) ) {
				return response()->json( [
					'result' => 'ko',
					'error'  => 'The originally uploaded image file cannot be found.'
				], 400 );
			}

			@set_time_limit( 900 );
			Media::saveImage( $contentField, $media );
		}

		$endTime = microtime(true);

		return response()->json( [
			'result'   => 'ok',
			'id'       => $mediaId,
			'filename' => $media->filename,
			'time'     => round( $endTime - $startTime, 2 )
		]);
	}


	public function resizeMedia( Request $request, $mediaId )
	{
		$startTime    = microtime(true);
		$media        = Media::find( $mediaId );
		$contentTypes = ContentType::all();

		Media::generateThumb( $media );


		// ContentFields con questo mediaId
		$listContentFields = [];

		foreach ( $contentTypes as $contentType ) {

			$contentFieldsImages = ContentField::whereIn( 'type', array( 'image_upload', 'gallery' ) )->where('content_type_id', $contentType->id)->get();

			foreach ( $contentFieldsImages as $contentFieldsImage ) {

				$tmpRecords = DB::table($contentType->content_type)->where($contentFieldsImage->name, $mediaId)->first();

				if ( $tmpRecords ){
					$listContentFields[] = $contentFieldsImage;
				}

			}

		}

		foreach ( $listContentFields as $listContentField ) {
			Media::saveImage( $listContentField, $media );
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

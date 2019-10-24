<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Content;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Kaleidoscope\Factotum\Category;
use Kaleidoscope\Factotum\Content;
use Kaleidoscope\Factotum\ContentCategory;
use Kaleidoscope\Factotum\ContentField;
use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\Media;
use stdClass;

class ReadController extends Controller
{
	public function getList(Request $request)
	{
		$contentTypeId = $request->input('contentTypeId');

		$contentId = $request->input('contentId');

		$query = Content::where('content_type_id', $contentTypeId);

		if ( $contentId ) {
			$query = $query->where('id', '<>' , $contentId);
		}

		$contents = $query->orderBy('id','DESC')->get();

		return response()->json( [ 'result' => 'ok', 'contents' => $contents ]);
	}

	public function getContentsByType($contentTypeID)
	{
		if ($contentTypeID) {
			$contents = Content::where('content_type_id', '=', $contentTypeID)->get();

			$tmp = array();
			if ( count($contents) > 0 ) {
				foreach ( $contents as $content ) {
					$tmp[$content->id] = $content->title;
				}
			}
			return response()->json( [ 'status' => 'ok', 'data' => $tmp ]);
		}

		return response()->json( [ 'status' => 'ko' ] );
	}


	public function getDetail(Request $request, $id)
	{
		$content = Content::find($id);

		if ( $content ) {

			$content_categories = ContentCategory::where( 'content_id', $id )->pluck('category_id')->all();

			$content_type = ContentType::find( $content->content_type_id );

			$dataContent = DB::table( $content_type->content_type )->where( 'content_id', $content->id )->where( 'content_type_id', $content_type->id)->first();

//			$content_fields = ContentField::where( 'content_type_id', $content_type->id )->whereIn( 'type', array( 'image_upload' ) )->get();
			$content_fields = ContentField::where( 'content_type_id', $content_type->id )->get();

			if ( !$dataContent ) {
				$dataContent = new stdClass();
			}

			if ( $content_fields && sizeof($content_fields) > 0 ) {
				foreach ( $content_fields as $content_field ){

					if ( $content_field->type == 'image_upload') {

						$tmpMedia = Media::find($dataContent->{$content_field->name});
						if ( $tmpMedia ) {
							$tmpMedia->url = $tmpMedia->url ? url( $tmpMedia->url ) : null;
						}
						$dataContent->{$content_field->name} = [ $tmpMedia ];

					} elseif ( $content_field->type == 'gallery') {

						$tmpListMedia = $dataContent->{$content_field->name};
						$tmpListMedia = explode( ',', $tmpListMedia );

						foreach ( $tmpListMedia as $index => $tmpMedia ) {
							$tmpListMedia[$index] = Media::find($tmpMedia);
							$tmpListMedia[$index]->url = ( $tmpListMedia[$index]->url ? url( $tmpListMedia[$index]->url ) : null );
						}
						$dataContent->{$content_field->name} = $tmpListMedia;

					} else {

						$dataContent->{$content_field->name} = isset( $dataContent->{$content_field->name} ) ? $dataContent->{$content_field->name} : '';

					}


				}
			}

			return response()->json( [ 'result' => 'ok', 'content' => $content, 'data' => $dataContent, 'content_categories' => $content_categories ]);
		}

		return $this->_sendJsonError('Campo non trovato.');
	}
}


<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Content;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Kaleidoscope\Factotum\Category;
use Kaleidoscope\Factotum\Content;
use Kaleidoscope\Factotum\CategoryContent;
use Kaleidoscope\Factotum\ContentField;
use Kaleidoscope\Factotum\ContentType;
use Kaleidoscope\Factotum\Library\Utility;
use Kaleidoscope\Factotum\Media;
use stdClass;

class ReadController extends Controller
{


	public function getList( Request $request, $contentTypeId )
	{
		$lang      = $request->input('lang');
		$limit     = $request->input('limit');
		$offset    = $request->input('offset');
		$sort      = $request->input('sort');
		$direction = $request->input('direction');
		$contentId = $request->input('contentId');

		if ( !$sort ) {
			$sort = 'id';
		}

		if ( !$direction ) {
			$direction = 'DESC';
		}

		$query = Content::with('user.profile')
						->with('categories')
						->where('content_type_id', $contentTypeId)
						->orderBy($sort, $direction);

		if ( $lang ) {
			$query->where( 'lang', $lang );
		}

		if ( $limit ) {
			$query->take($limit);
		}

		if ( $offset ) {
			$query->skip($offset);
		}

		if ( $contentId ) {
			$query = $query->where('id', '<>' , $contentId);
		}

		if ( $request->input('filter') ) {
			$query->where( 'title', 'like', '%' . $request->input('filter') . '%' );
		}


		$contentList = $query->get();

		return response()->json( [
			'result'   => 'ok',
			'contents' => $contentList,
			'total'    => Content::where('content_type_id', $contentTypeId)
									->where( 'lang', $lang )
									->count()
		]);
	}


	public function getListBySearch( Request $request, $contentTypeId )
	{
		$lang   = $request->input('lang');
		$search = $request->input('search');

		$query = Content::where('content_type_id', $contentTypeId)
						->where( 'title', 'like', '%' . $search . '%' );

		if ( $lang ) {
			$query->where( 'lang', $lang );
		}

		$contentList = $query->get();

		return response()->json( [
			'result'   => 'ok',
			'contents' => $contentList
		]);
	}


	public function getContentsByType( Request $request, $contentTypeID )
	{
		if ( $contentTypeID ) {

			$lang = $request->input('lang');

			$query = Content::where('content_type_id', '=', $contentTypeID);

			if ( $lang ) {
				$query->where( 'lang', $lang );
			}

			$contents = $query->get();

			$tmp = [];
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
		$content = Content::with('categories')->where( 'id', $id )->first();

		if ( $content ) {

			// fb image
			$tmpMedia = Media::find($content->fb_image);
			if ( $tmpMedia ) {
				$content->fb_image = [ $tmpMedia ];
			}

			$contentType   = ContentType::find( $content->content_type_id );
			$contentFields = ContentField::where( 'content_type_id', $contentType->id )->get();
			$dataContent   = DB::table( $contentType->content_type )
								->where( 'content_id',      $content->id )
								->where( 'content_type_id', $contentType->id)
								->first();


			if ( $contentFields && $contentFields->count() > 0 ) {

				foreach ( $contentFields as $contentField ) {

					switch ( $contentField->type ) {

						case 'image_upload':
						case 'file_upload':
							$content->{$contentField->name} = ( isset( $dataContent->{$contentField->name} ) ? [ Media::find($dataContent->{$contentField->name}) ] : '' );
						break;

						case 'gallery':
							$tmpListMedia = ( isset($dataContent->{$contentField->name}) ? $dataContent->{$contentField->name} : null );
							if ( !$tmpListMedia ) {
								$content->{$contentField->name} = '';
							} else {
								$content->{$contentField->name} = Media::whereIn( 'id', explode( ',', $tmpListMedia ) )->get();
							}
						break;

						case 'linked_content':
						case 'multiple_linked_content':
							$tmpLinkedContent = ( isset($dataContent->{$contentField->name}) ? $dataContent->{$contentField->name} : null );
							if ( !$tmpLinkedContent ) {
								$content->{$contentField->name} = '';
							} else {
								$ids = explode( ',', $tmpLinkedContent );
								$content->{$contentField->name} = Content::whereIn( 'id', $ids )->orderByRaw("FIELD(id, $tmpLinkedContent)")->get();
							}
						break;

						case 'multiselect':
							$content->{$contentField->name} = ( isset($dataContent->{$contentField->name}) ? explode( ';', $dataContent->{$contentField->name} ) : '' );
						break;

						case 'checkbox':
							$content->{$contentField->name} = ( isset($dataContent->{$contentField->name}) && ($dataContent->{$contentField->name} == 1 || $dataContent->{$contentField->name} == '1') ? true : false );
						break;

						case 'datetime':
							$content->{$contentField->name} = ( isset($dataContent->{$contentField->name}) ? strtotime($dataContent->{$contentField->name}) * 1000 : '' );
						break;

						default:
							$content->{$contentField->name} = ( isset( $dataContent->{$contentField->name} ) ? $dataContent->{$contentField->name} : '' );
						break;

					}

				}

			}

			return response()->json([
				'content'    => $content
			]);
		}

		return $this->_sendJsonError( 'Content not found', 404 );
	}

}

